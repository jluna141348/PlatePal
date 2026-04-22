# PlatePal — Laravel Reverb Real-Time Messaging Setup

## 1. Install Reverb
```bash
composer require laravel/reverb
php artisan reverb:install
```

## 2. Install JS dependencies
```bash
npm install --save-dev laravel-echo pusher-js
```
> Note: The messaging view loads Echo + Pusher from CDN so no bundler config is needed,
> but if you use Vite you can import them instead.

## 3. Add to your .env
```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=platepal
REVERB_APP_KEY=platepal-key
REVERB_APP_SECRET=platepal-secret
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

## 4. Enable broadcasting in config/app.php (Laravel 10)
Uncomment:
```php
App\Providers\BroadcastServiceProvider::class,
```
Laravel 11 handles this automatically via `bootstrap/app.php`.

## 5. Register channels route in bootstrap/app.php (Laravel 11)
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    channels: __DIR__.'/../routes/channels.php',  // ← add this
    ...
)
```
For Laravel 10, `routes/channels.php` is auto-loaded by `BroadcastServiceProvider`.

## 6. Register the Role middleware

**Laravel 11** — `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

**Laravel 10** — `app/Http/Kernel.php`:
```php
protected $routeMiddleware = [
    // ...
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
```

## 7. Run migrations & storage link
```bash
php artisan migrate
php artisan storage:link
```

## 8. Start all services (3 terminals)
```bash
# Terminal 1 — web server
php artisan serve

# Terminal 2 — Reverb WebSocket server
php artisan reverb:start

# Terminal 3 — queue worker (handles broadcast jobs)
php artisan queue:work
```

---

## File Summary

| File | Purpose |
|------|---------|
| `app/Events/MessageSent.php` | Broadcasts on `chat.{receiverId}` + `chat.{senderId}` private channels |
| `app/Http/Controllers/MessageController.php` | `send()` calls `broadcast(new MessageSent($message))` |
| `routes/channels.php` | Authorizes `chat.{userId}` private + `presence.{roomId}` presence channels |
| `resources/views/shared/messages.blade.php` | Full real-time UI with Echo, typing whispers, presence online status |

## How real-time features work

| Feature | Mechanism |
|---------|-----------|
| Receive new messages instantly | `Echo.private('chat.X').listen('.message.sent', ...)` |
| Typing indicator (animated dots) | `channel.whisper('typing', ...)` + `listenForWhisper(...)` |
| Online / offline status | `Echo.join('presence.X-Y').here/joining/leaving(...)` |
| Sidebar preview updates | JS updates the DOM for non-active conversations |
| Optimistic send (no flicker) | Message appended immediately, confirmed/removed on server response |
| Connection status bar | Pusher connection events → show/hide warning banner |
