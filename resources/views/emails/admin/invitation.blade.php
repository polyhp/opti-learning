<x-mail::message>
# Bonjour {{ $user->first_name }},

Vous avez été invité(e) à rejoindre l'équipe d'administration de la plateforme **OptiLearning**.

Pour finaliser la création de votre compte administrateur et configurer vos accès, veuillez cliquer sur le bouton ci-dessous :

<x-mail::button :url="$url" color="primary">
Configurer mon compte
</x-mail::button>

*Ce lien de configuration est sécurisé et expirera dans 48 heures.*

Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet e-mail.

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
