<!-- resources/views/auth/verify-email.blade.php -->
<x-layout>
    <div class="max-w-sm mx-auto mt-10">
        <div class="card bg-base-100 shadow-xl w-full max-w-sm mx-auto">
            <div class="card-body p-4 space-y-3">
                <h2 class="card-title text-xl font-bold">
                    Verify Your Email
                </h2>

                <p class="text-base-content/70 leading-relaxed">
                    Before you can continue, we need to verify your email address.
                    A verification link has been sent to:
                    <span class="font-semibold">{{ auth()->user()->email }}</span>
                </p>

                @if (session('message'))
                    <div class="alert alert-success shadow">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="space-y-2">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="btn btn-primary w-full btn-sm" type="submit">
                            Resend Verification Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-ghost w-full btn-sm">
                            Logout
                        </button>
                    </form>
                </div>

                <div class="divider"></div>

                <p class="text-sm text-base-content/60">
                    Didn’t receive the email? Check your spam folder or resend the link above.
                </p>
            </div>
        </div>
    </div>
</x-layout>
