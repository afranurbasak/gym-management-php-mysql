# Gym Management System

<p align="center"><img src="er-diagram.png" width="700" alt="ER diyagramı / ER diagram"></p>

## 🇹🇷 Türkçe

### Proje Hakkında
Bir spor salonunun üyelerini, üyelik paketlerini, eğitmenlerini, ders oturumlarını ve rezervasyonlarını yöneten bir web uygulamasıdır. İlişkisel veritabanı tasarımı ER diyagramı ile modellenmiş, tablolar arasındaki ilişkiler yabancı anahtar (foreign key) kısıtlarıyla korunmuştur.

### Özellikler
- Üye listesi ve üyelik paketi seçerek yeni üye kaydı
- Eğitmen, salon, başlangıç zamanı ve kapasite bilgisiyle ders oturumları
- Kalan kapasite kontrolü yapan rezervasyon işlemi (fazla kayıt engellenir)
- Rezervasyon listesi
- `ON DELETE CASCADE / SET NULL` kurallı yabancı anahtar kısıtları
- Kullanıcı girdileri için hazır sorgular (prepared statements) ve tür dönüşümü

### Kullanılan Teknolojiler
PHP (mysqli), MySQL / MariaDB, HTML

### Kurulum
1. XAMPP veya PHP 8 + MySQL/MariaDB içeren bir ortam kurun.
2. Depoyu klonlayıp web sunucusunun kök dizinine (ör. `htdocs/`) kopyalayın:
   ```bash
   git clone https://github.com/afranurbasak/gym-management-php-mysql.git
   ```
3. `spor_salon_db.sql` dosyasını phpMyAdmin veya MySQL komut satırı ile içe aktarın. Bu işlem `spor_salon_db` veritabanını örnek verilerle oluşturur.
4. Gerekirse `db.php` dosyasındaki veritabanı bağlantı bilgilerini düzenleyin.

### Kullanım
Tarayıcıda `http://localhost/gym-management-php-mysql/` adresini açın. Ana sayfadan üyeler, üye ekleme, ders oturumları, rezervasyon yapma ve rezervasyon listesi sayfalarına geçebilirsiniz.

Örnek veriler kurgusaldır. Arayüz metinleri Türkçedir.

## 🇬🇧 English

### About the Project
A web application that manages a gym's members, membership packages, instructors, class sessions and reservations. The relational database is modelled with an ER diagram, and relationships between tables are enforced with foreign-key constraints.

### Features
- Member list and new member registration with membership package selection
- Class sessions with instructor, room, start time and capacity
- Reservations with a remaining-capacity check (overbooking is prevented)
- Reservation list
- Foreign-key constraints with `ON DELETE CASCADE / SET NULL` rules
- Prepared statements and type casting for user input

### Technologies
PHP (mysqli), MySQL / MariaDB, HTML

### Installation
1. Install XAMPP or any PHP 8 + MySQL/MariaDB environment.
2. Clone the repository into your web server's root directory (e.g. `htdocs/`):
   ```bash
   git clone https://github.com/afranurbasak/gym-management-php-mysql.git
   ```
3. Import `spor_salon_db.sql` with phpMyAdmin or the MySQL command line. This creates the `spor_salon_db` database with sample data.
4. If needed, edit the database connection settings in `db.php`.

### Usage
Open `http://localhost/gym-management-php-mysql/` in your browser. From the home page you can open the members, add member, class sessions, make reservation and reservation list pages.

Sample data is fictional. The user interface is in Turkish.
