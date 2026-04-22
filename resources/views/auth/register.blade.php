{{-- Resources/views/auth/register.blade.php --}}
<x-layouts.app :title="'Register - PlatePal'">

<div style="max-width:420px;margin:80px auto;padding:24px;background:var(--white);border-radius:12px;box-shadow:var(--shadow);">
    <h2 style="font-size:24px;font-weight:700;margin-bottom:8px;">Create an account</h2>
    <p class="text-muted mb-3">Join PlatePal as a client</p>

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <p class="mt-3 text-center fs-sm">
        Already have an account? <a href="{{ route('login') }}">Sign In</a>
    </p>
</div>

</x-layouts.app>
