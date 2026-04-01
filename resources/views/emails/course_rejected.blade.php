<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formation rejetée</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #0D2B42; padding: 20px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; }
        .content { padding: 30px 20px; background-color: #f9f9f9; }
        .reason-box { background-color: #fff3cd; border-left: 4px solid #FF6B35; padding: 15px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #FF6B35; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $course->formateur->user->first_name }},</p>
            
            <p>Nous vous remercions d'avoir soumis votre formation <strong>"{{ $course->title }}"</strong> sur notre plateforme.</p>
            
            <p>Après examen par notre équipe qualité, nous ne pouvons malheureusement pas approuver sa publication en l'état.</p>
            
            <div class="reason-box">
                <strong>Motif du refus :</strong><br>
                {!! nl2br(e($rejection_reason)) !!}
            </div>
            
            <p>Nous vous invitons à apporter les corrections nécessaires et à soumettre à nouveau votre formation.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('formateur.courses.show', $course) }}" class="btn">Gérer ma formation</a>
            </div>
            
            <p>Cordialement,<br>L'équipe d'administration {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            Cet e-mail a été envoyé automatiquement, merci de ne pas y répondre directement.
        </div>
    </div>
</body>
</html>
