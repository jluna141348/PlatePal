{{-- Resources/views/auth/caterer-register.blade.php --}}
<x-layouts.app :title="'Caterer Registration - PlatePal'">

<div style="max-width:560px;margin:60px auto;padding:32px;background:var(--white);border-radius:12px;box-shadow:var(--shadow);">
    <h2 style="font-size:24px;font-weight:700;margin-bottom:8px;">Join as a Caterer</h2>
    <p class="text-muted mb-4">Create your caterer profile and start receiving bookings</p>

    <form method="POST" action="{{ route('caterer.register.post') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Business Name</label>
                <input type="text" name="business_name" class="form-control" required autofocus>
            </div>
            <div class="col-12">
                <label class="form-label">Your Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Barangay</label>
                <select name="barangay" class="form-control" required>
                    <option value="">Select Barangay</option>
                    <option>Magugpo Poblacion</option>
                    <option>Apokon</option>
                    <option>Visayan Village</option>
                    <option>Nueva Fuerza</option>
                    <option>Mankilam</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Create Account</button>
            </div>
        </div>
    </form>

    <p class="mt-3 text-center fs-sm">
        Already have a caterer account? <a href="{{ route('caterer.login') }}">Sign In</a>
    </p>
</div>

</x-layouts.app>
