{{-- Resources/views/auth/caterer-login.blade.php --}}
<x-layouts.app :title="'Caterer Login - PlatePal'">

<div style="max-width:420px;margin:80px auto;padding:24px;background:var(--white);border-radius:12px;box-shadow:var(--shadow);">
    <h2 style="font-size:24px;font-weight:700;margin-bottom:8px;">Caterer Sign In</h2>
    <p class="text-muted mb-3">Access your caterer dashboard</p>

    <form method="POST" action="{{ route('caterer.login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign In</button>
    </form>

    <p class="mt-3 text-center fs-sm">
        Not a caterer yet? <a href="{{ route('caterer.register') }}">Register as Caterer</a>
    </p>
</div>

</x-layouts.app>
