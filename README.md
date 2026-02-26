# Digitálne Portfólio Žiakov

PHP backend systém pre správu digitálnych portfólií žiakov.

## Inštalácia

1. Naklonujte repozitár:
   ```bash
   git clone <url-repozitára>
   cd Portfolia
   ```

2. Nainštalujte Composer závislosti:
   ```bash
   composer install
   ```

3. Skopírujte projekt do XAMPP `htdocs` adresára:
   ```
   C:\xampp\htdocs\Portfolia
   ```

4. Vytvorte databázu v phpMyAdmin:
   - Názov databázy: `digitalne_portfolio`
   - Importujte SQL súbory z `migrations/` adresára

5. Nakonfigurujte databázu v `src/config/database.php`:
   ```php
   'username' => 'root',
   'password' => '',
   ```

6. Spustite Apache a MySQL v XAMPP Control Panel

7. Otvorte aplikáciu v prehliadači:
   ```
   http://localhost/Portfolia/public
   ```

## Role a Ich Práva

### ADMIN
- **Správa používateľov** - vytváranie, úprava, mazanie účtov
- **Správa tried** - vytváranie a priraďovanie tried
- **Správa predmetov** - vytváranie predmetov a priraďovanie učiteľov
- **Prehľad všetkých portfólií** - kompletný prístup k systému

### UČITEĽ
- **Prezerá svoje predmety** - vidí predmety, ktoré vyučuje
- **Prezerá triedy** - vidí triedy priradené k jeho predmetom
- **Prezerá portfóliá žiakov** - prístup k prácam žiakov z jeho tried
- **Hodnotí práce** - môže pridávať hodnotenia a komentáre

### ŽIAK
- **Vidí svoje predmety** - prehľad predmetov, ktoré navštevuje
- **Nahráva projekty** - môže nahrávať práce ku konkrétnym predmetom
- **Spravuje vlastné práce** - maže a upravuje svoje portfóliá
- **Prezerá hodnotenia** - vidí hodnotenia a komentáre od učiteľov

## API Endpoints

### Autentifikácia
- `POST /api/login` - Prihlásenie používateľa
  - Body: `{ "email": "meno.priezvisko@centrumnadania.sk", "password": "heslo" }`
  - Response: `{ "token": "jwt_token" }`

### Žiak
- `POST /api/student/portfolio` - Nahratie portfólia
  - Headers: `Authorization: Bearer {token}`
  - Body: `{ "name": "názov", "description": "popis", "subject_id": 1 }`

### Učiteľ
- `GET /api/teacher/portfolio/{student_id}` - Zobrazenie portfólia žiaka
  - Headers: `Authorization: Bearer {token}`

### Admin
- `POST /api/admin/class` - Vytvorenie triedy
  - Headers: `Authorization: Bearer {token}`
  - Body: `{ "name": "názov triedy" }`
- `POST /api/admin/subject` - Vytvorenie predmetu
  - Headers: `Authorization: Bearer {token}`
  - Body: `{ "name": "názov predmetu", "teacher_id": 1 }`

### Upload Súborov
- `POST /api/student/portfolio/upload` - Nahratie súboru
  - Headers: `Authorization: Bearer {token}`
  - Form data: `file` (max 50MB, povolené formáty: pdf, docx, zip, jpg, png)

## Databázová Štruktúra

### Tabuľky
- `users` - Používatelia (ADMIN, TEACHER, STUDENT)
- `classes` - Triedy
- `subjects` - Predmety
- `portfolios` - Portfóliá žiakov
- `files` - Súbory v portfóliách

## Bezpečnosť

- JWT autentifikácia
- Role-based access control
- Validácia emailovej domény `@centrumnadania.sk`
- Kontrola veľkosti a formátu súborov

## Štruktúra Projektu

```
Portfolia/
├── public/
│   └── index.php          # Vstupný bod aplikácie
├── src/
│   ├── Auth/              # JWT autentifikácia
│   ├── Controllers/       # API controllery
│   ├── Middleware/        # Role middleware
│   └── config/           # Konfigurácia databázy
├── migrations/           # SQL migrácie
├── storage/              # Ukladanie súborov
├── composer.json         # Composer závislosti
└── README.md            # Tento súbor
```

## Požiadavky

- PHP 8.x
- MySQL/MariaDB
- Composer
- XAMPP (pre lokálny vývoj)
