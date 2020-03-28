Hello {{$user->name}}
You have changed your email, Please verify it using this link:
{{route('verify', $user->verification_token )}} 
