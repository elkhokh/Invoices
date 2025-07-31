<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<h1 align="center"> Invoices</h1>

<p align="center">
  هذا المشروع هو تطبيق Laravel يهدف إلى [وصف عام – مثل "إدارة المنتجات والفواتير" أو "نظام حجوزات"].<br>
  تم بناؤه باستخدام Laravel ويدعم خصائص مثل CRUD، العلاقات بين الجداول، التحقق من البيانات، الجلسات، وFlash messages.
</p>

---

## 🛠 المتطلبات

- PHP >= 8.1
- Composer
- MySQL أو PostgreSQL
- Node.js و npm (لو فيه frontend)
- Laravel ^10.x

---

## 🚀 خطوات التثبيت

```bash
git clone https://github.com/elkhokh/Invoices.git
cd your-laravel-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev # لو عندك frontend assets
php artisan serve
