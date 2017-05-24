Kliknite na sljedeći link kako bi verificirali Vaš račun: <a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">{{ $link }}</a>
