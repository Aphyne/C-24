# Dokumentasi Sistem Login dan User Management - Klinik Dashboard

## Overview
Dokumentasi ini menjelaskan sistem login dan user management yang terintegrasi dengan aplikasi klinik, termasuk struktur database, keamanan, dan fungsionalitas yang tersedia.

## Struktur Database

### Tabel Utama

#### 1. `tb_user`
Tabel utama untuk menyimpan data user sistem:
```sql
- id_user (Primary Key, Auto Increment)
- username (Unique, Required)
- password (Plain text - untuk kompatibilitas dengan sistem yang ada)
- jabatan (ENUM: admin, pembayaran, pendaftaran, pemeriksaan, kasir, apoteker, dokter)
- nama_lengkap
- email
- no_hp
- alamat
- foto_profile
- status_aktif (ENUM: aktif, nonaktif, suspended)
- last_login
- login_count
- ip_address_last
- password_changed_at
- created_at
- updated_at
- created_by
```

#### 2. `user_login_log`
Tabel untuk tracking aktivitas login:
```sql
- id (Primary Key, Auto Increment)
- user_id (Foreign Key ke tb_user)
- username
- login_time
- logout_time
- ip_address
- user_agent
- status_login (ENUM: success, failed, blocked)
- session_duration (dalam menit)
- login_method (ENUM: web, mobile, api)
- failure_reason
- browser_info
- location_info
```

#### 3. `user_role_permissions`
Tabel untuk mengelola permission berdasarkan role:
```sql
- id (Primary Key, Auto Increment)
- role_name (Sesuai dengan jabatan di tb_user)
- module_name (pasien, dokter, obat, staff, pemeriksaan, pembayaran, keuntungan, dll)
- permission_type (ENUM: view, create, edit, delete, export, admin)
- is_granted (Boolean)
- description
- created_at
- updated_at
```

#### 4. `user_sessions`
Tabel untuk mengelola sesi aktif:
```sql
- session_id (Primary Key)
- user_id (Foreign Key ke tb_user)
- ip_address
- user_agent
- created_at
- last_activity
- expires_at
- is_active
```

## Data Sample Users

Sistem menyediakan data sample user untuk testing:

| Username | Password | Jabatan | Nama Lengkap |
|----------|----------|---------|--------------|
| admin | admin | admin | Administrator System |
| kasir | kasir | pembayaran | Siti Kasir |
| pendaftaran | pendaftaran | pendaftaran | Budi Pendaftaran |
| pemeriksaan | pemeriksaan | pemeriksaan | Dr. Rina Pemeriksaan |
| evina | evina | pembayaran | Evina Kasir |
| pegawai | pegawai | pembayaran | Ahmad Pegawai |
| apoteker1 | apoteker123 | apoteker | Apt. Sarah Apoteker |
| dokter1 | dokter123 | dokter | Dr. Joko Widodo |
| supervisor | supervisor123 | admin | Supervisor Klinik |
| manager | manager123 | admin | Manager Operasional |

## Flow Sistem Login

### Login Process (login/index.php)
1. User mengakses halaman login
2. Input username dan password
3. Sistem melakukan query ke `tb_user` dengan plain text matching
4. Jika berhasil:
   - Set session berdasarkan jabatan
   - Update `last_login`, `login_count`, `ip_address_last` di `tb_user`
   - Insert log ke `user_login_log` dengan status 'success'
   - Redirect ke dashboard utama (`../index.php`)
5. Jika gagal:
   - Insert log ke `user_login_log` dengan status 'failed'
   - Tampilkan pesan error

### Session Management
- Session disimpan dengan key `jabatan` dan `user`
- Session berlaku selama browser aktif
- Logout menghapus semua session data

### Role-Based Access
Berdasarkan jabatan, user memiliki akses berbeda:
- **admin**: Akses penuh ke semua modul
- **pembayaran/kasir**: Fokus pada modul pembayaran dan kasir
- **pendaftaran**: Fokus pada pendaftaran pasien
- **pemeriksaan**: Fokus pada modul pemeriksaan dan medical record
- **apoteker**: Fokus pada manajemen obat dan stok
- **dokter**: Akses ke data pasien dan pemeriksaan

## Views dan Analytics

### 1. `view_user_dashboard_summary`
Ringkasan statistik user untuk dashboard:
- Total users, users aktif, nonaktif, suspended
- Active users dalam 24 jam dan 7 hari terakhir
- Login attempts hari ini
- Failed logins hari ini

### 2. `view_user_activity_summary`
Detail aktivitas per user:
- Login count dan pattern
- Failed attempts
- Average session duration
- Days since last login

### 3. `view_user_role_summary`
Statistik berdasarkan role/jabatan:
- Total users per role
- Active users per role
- Accessible modules
- Admin permissions

### 4. `view_login_statistics`
Statistik login harian:
- Total attempts, successful, failed
- Success rate
- Unique users dan IPs
- Average session duration

### 5. `view_security_monitoring`
Monitoring keamanan sistem:
- Failed login attempts monitoring
- Suspicious IP tracking
- Security metrics dan risk levels

## Fitur Keamanan

### Current Implementation
- Plain text password (untuk kompatibilitas)
- Session-based authentication
- Login attempt logging
- IP address tracking
- User agent logging

### Rekomendasi Improvement
1. **Password Hashing**: Implementasi MD5/SHA256/bcrypt
2. **Session Timeout**: Automatic logout setelah periode inactive
3. **Account Lockout**: Lock account setelah failed attempts berlebihan
4. **Two-Factor Authentication**: Implementasi 2FA untuk admin
5. **Password Policy**: Requirement password yang kuat
6. **Login Rate Limiting**: Batasi login attempts per IP
7. **Audit Trail**: Log semua aktivitas user

## Integrasi dengan Modul Lain

### Dashboard Integration
- User data terintegrasi dengan semua modul (pasien, dokter, obat, dll)
- Permission-based menu display
- Activity tracking across modules

### Data Relationship
- `user_login_log.user_id` → `tb_user.id_user`
- `user_role_permissions.role_name` → `tb_user.jabatan`
- `user_sessions.user_id` → `tb_user.id_user`

## Query Examples

### Login Verification
```sql
SELECT * FROM tb_user 
WHERE username='admin' AND password='admin' AND status_aktif='aktif';
```

### Update Last Login
```sql
UPDATE tb_user 
SET last_login=NOW(), login_count=login_count+1, ip_address_last='192.168.1.100'
WHERE username='admin';
```

### Insert Login Log
```sql
INSERT INTO user_login_log (user_id, username, login_time, ip_address, status_login)
VALUES (1, 'admin', NOW(), '192.168.1.100', 'success');
```

### Get User Permissions
```sql
SELECT module_name, permission_type 
FROM user_role_permissions 
WHERE role_name='admin' AND is_granted=1;
```

## Troubleshooting

### Common Issues
1. **Login Failed**: Check username/password case sensitivity
2. **Session Lost**: Ensure session_start() di setiap halaman
3. **Access Denied**: Verify user role permissions
4. **Multiple Login**: Check session management

### Debug Queries
```sql
-- Check failed logins
SELECT * FROM user_login_log WHERE status_login='failed' ORDER BY login_time DESC;

-- Check user status
SELECT username, status_aktif, last_login FROM tb_user;

-- Check permissions
SELECT * FROM user_role_permissions WHERE role_name='admin';
```

## File Terkait

### Core Files
- `login/index.php` - Halaman login utama
- `login/logout.php` - Proses logout
- `koneksi.php` - Database connection
- `index.php` - Dashboard utama dengan session check

### Database Files
- `klinik_dashboard.sql` - Complete database schema
- `README_LOGIN_SYSTEM.md` - Dokumentasi ini

## Maintenance

### Regular Tasks
1. Clean old login logs (>6 bulan)
2. Review failed login patterns
3. Update user permissions sesuai kebutuhan
4. Monitor security metrics
5. Backup user data secara berkala

### Monitoring Queries
```sql
-- Daily login summary
SELECT DATE(login_time) as date, COUNT(*) as logins 
FROM user_login_log 
WHERE login_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY DATE(login_time);

-- Security alerts
SELECT * FROM view_security_monitoring WHERE risk_level='high';
```

---
*Dokumentasi ini dibuat berdasarkan analisis sistem login yang ada dan struktur database klinik_dashboard.sql*
