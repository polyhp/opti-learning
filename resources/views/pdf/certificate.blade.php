<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat - {{ $course->title }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0px;
            padding: 0px;
            line-height: 1.5;
            background-color: #0B1A3E; /* Fond externe Bleu-nuit */
        }
        .page-wrap {
            padding: 25px;
            width: 100%;
            height: 100vh;
            box-sizing: border-box;
        }
        .border-orange {
            border: 4px solid #F97316;
            height: 100%;
            width: 100%;
            box-sizing: border-box;
            background-color: #ffffff;
            position: relative;
        }
        /* Décorations de coin */
        .decor-top-left {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100px;
            height: 100px;
            border-top: 6px solid #0B1A3E;
            border-left: 6px solid #0B1A3E;
        }
        .decor-bottom-right {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 100px;
            height: 100px;
            border-bottom: 6px solid #0B1A3E;
            border-right: 6px solid #0B1A3E;
        }
        
        .watermark {
            position: absolute;
            top: 300px;
            left: 200px;
            font-size: 90px;
            color: #fff5ec;
            z-index: 0;
            font-weight: bold;
            letter-spacing: 5px;
            text-align: center;
        }

        .content {
            padding: 50px;
            text-align: center;
            z-index: 10;
            position: relative;
        }
        .header {
            margin-bottom: 25px;
            width: 100%;
            text-align: center;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #0B1A3E;
            letter-spacing: 2px;
        }
        .logo-accent {
            color: #F97316;
        }
        
        .title {
            font-size: 55px;
            text-transform: uppercase;
            letter-spacing: 6px;
            margin-bottom: 10px;
            color: #0B1A3E;
            font-family: 'Georgia', serif;
        }
        .subtitle {
            font-size: 16px;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 40px;
            font-weight: bold;
        }
        
        .presented-to {
            font-size: 20px;
            margin-bottom: 15px;
            color: #475569;
        }
        .student-name {
            font-size: 46px;
            color: #0B1A3E;
            font-family: 'Georgia', serif;
            font-style: italic;
            border-bottom: 2px solid #F97316;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 25px;
            min-width: 450px;
        }
        
        .description {
            font-size: 18px;
            margin: 0 auto;
            max-width: 800px;
            color: #475569;
        }
        .course-title {
            font-size: 28px;
            font-weight: bold;
            color: #0B1A3E;
            margin: 20px 0 25px 0;
            font-family: 'Georgia', serif;
        }
        
        .score-box {
            display: inline-block;
            background-color: #0B1A3E;
            color: #ffffff;
            padding: 10px 30px;
            border-radius: 50px;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .score-box span {
            color: #F97316;
            font-weight: bold;
            font-size: 20px;
        }
        
        .footer {
            margin-top: 50px;
            width: 100%;
            position: absolute;
            bottom: 60px;
            left: 0;
        }
        .signature-table {
            width: 85%;
            margin: 0 auto;
        }
        .signature-table td {
            width: 33%;
            text-align: center;
            vertical-align: bottom;
        }
        .signature-line {
            width: 80%;
            margin: 0 auto;
            border-bottom: 1px solid #0B1A3E;
            margin-bottom: 15px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 18px;
            color: #0B1A3E;
        }
        .signature-title {
            font-size: 14px;
            color: #F97316;
            margin-top: 5px;
        }
        
        /* Médaille centrale */
        .medal {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            background-color: #0B1A3E;
            border-radius: 50%;
            text-align: center;
            border: 5px double #F97316;
        }
        .medal-content {
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
            margin-top: 40px;
            text-transform: uppercase;
        }
        .medal-accent {
            color: #F97316;
            font-size: 16px;
        }

        .certificate-code {
            position: absolute;
            bottom: 20px;
            left: 30px;
            font-size: 11px;
            color: #64748b;
            text-align: left;
        }
        .qr-code {
            position: absolute;
            bottom: 20px;
            right: 30px;
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="border-orange">
            <div class="decor-top-left"></div>
            <div class="decor-bottom-right"></div>
            
            <div class="watermark">
                EXCELLENCE ACADÉMIQUE
            </div>

            <div class="content">
                <div class="header">
                    <div class="logo">OPTI<span class="logo-accent">LEARNING</span></div>
                </div>

                <div class="title">Certificat de Réussite</div>
                <div class="subtitle">Délivré pour des performances exceptionnelles</div>

                <div class="presented-to">Ce certificat est fièrement décerné à</div>
                <div class="student-name">{{ $user->first_name }} {{ $user->last_name }}</div>

                <div class="description">
                    En reconnaissance de son engagement et pour avoir complété avec succès toutes les exigences du cours professionnel certifiant :
                </div>

                <div class="course-title">« {{ $course->title }} »</div>

                <div class="score-box">
                    Obtenu à l'examen avec la note de <span>{{ isset($score) ? $score : '' }}/20</span>
                </div>
            </div>

            <div class="footer">
                <table class="signature-table">
                    <tr>
                        <td>
                            <div class="signature-line"></div>
                            <div class="signature-name">{{ $course->formateur->user->first_name }} {{ $course->formateur->user->last_name }}</div>
                            <div class="signature-title">Instructeur Principal</div>
                        </td>
                        <td>
                            <div class="medal">
                                <div class="medal-content">
                                    MENTION<br>
                                    <span class="medal-accent">HONORABLE</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="signature-line"></div>
                            <div class="signature-name">Direction OptiLearning</div>
                            <div class="signature-title">Délivré le {{ \Carbon\Carbon::parse($certificate->issued_at)->format('d/m/Y') }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="certificate-code">
                <strong>Réf. ID :</strong> {{ $certificate->certificate_code }}<br>
                Vérifiez l'authenticité de ce document via le code QR ci-contre.
            </div>

            <div class="qr-code">
                <img src="data:image/svg+xml;base64,{{ $qrcode }}" width="80" height="80" alt="QR Code" style="border: 2px solid #0B1A3E; padding: 2px;">
            </div>
        </div>
    </div>
</body>
</html>
