# CNG Supply Management

A management system for a CNG gas supply business, built for Mars Bangla Fuel Solution Ltd. It tracks gas bought from CNG pumps, delivered by truck to factory customers, and billed to them, along with the fleet, transport, diesel, and cash book.

Built with Laravel 11 and [sebastienheyd/boilerplate](https://github.com/sebastienheyd/boilerplate) (AdminLTE).

## Modules

### Loads

- Record each gas load: date, vehicle, source pump, destination factory, CNG purchased (m³), rate, purchase amount, fuel cost, and diesel
- Notifications when a load is added, and when a load has stayed inactive for more than 12 hours

### Factory billing

Each factory is billed by one of three methods:

- **Dispenser:** opening and closing meter readings
- **Weight scale:** first and second weights converted to m³
- **CNG pump slip:** volume from the pump slip

Each method records the bill, received volume and rate, the difference against the purchase, and cash received with a running balance. There is also a factory summary by date range.

- **Invoices** per factory, exportable, with a public verification link (`/factory/invoice/verify/{hash}`)

### Pumps

- Pump directory (CNG and diesel pumps)
- Payments to pumps with running balance, commission rate, and third-party pump purchases
- Pump summary by date range

### Fleet and transport

- **Vehicles:** type, driver details, status, and maintenance date
- **Vehicle documents** with expiry dates and a daily expiry check
- **Vehicle maintenance** costs
- **Vehicle income** per load: rent, driver food, maintenance, and other costs, with a printable filtered report
- **Transport trips:** route, rent, and cost breakdown (diesel, toll, labour, food, police, parking, and more), with export
- **Diesel:** purchase slips, litres, distance, and usage balance
- **Assets** with attached documents

### Cash book

- Cash books with opening balance, income and expense entries under entry headings, and filtered exports

### System

- Roles and permissions for every module, with create, update, and delete rights
- Activity log, row highlighting, and in-app notifications
- Media manager, log viewer, and daily database backups

## Scheduled tasks

| Task                                  | When          |
| ------------------------------------- | ------------- |
| `vehicle:check-documents`             | Daily, 09:00  |
| `loads:check-inactive`                | Hourly        |
| `backup:run` (Spatie Backup)          | Daily, 00:30  |
| Clean activity log older than 10 days | Daily         |
| Delete read notifications older than 60 days | Daily  |

Add the Laravel scheduler to cron so these run:

```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## Tech stack

| Layer    | Packages                                                       |
| -------- | -------------------------------------------------------------- |
| Backend  | PHP 8.2+, Laravel 11                                           |
| Admin UI | sebastienheyd/boilerplate, AdminLTE, Boilerplate Media Manager |
| Data     | Spatie Activitylog, Spatie Backup, Laravel Settings            |
| Tooling  | PHPUnit, Pint, Debugbar                                        |

## Getting started

### Requirements

- PHP 8.2+
- Composer
- MySQL (needed for backups through `mysqldump`)

### Installation

```bash
git clone https://github.com/mmrtonmoybd/cng-supply-management.git
cd cng-supply-management

composer install
cp .env.example .env
php artisan key:generate
# set the DB_* and MAIL_* values in .env
php artisan migrate
php artisan storage:link
```

Open `/register` and create the first account; it becomes the admin. Public registration stays off after that (`config/boilerplate/auth.php`). The admin then adds staff users and gives them roles.

### Run locally

```bash
php artisan serve
```

## Author

Moshiur Rahman — [rmedha037@gmail.com](mailto:rmedha037@gmail.com)
