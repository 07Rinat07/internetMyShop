<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>internetMyShop API Swagger</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css">
    <style>
        body {
            margin: 0;
            background: #f4f7fb;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .swagger-shell {
            padding: 24px 16px 40px;
        }

        .swagger-header {
            max-width: 1200px;
            margin: 0 auto 20px;
        }

        .swagger-header h1 {
            margin: 0 0 8px;
            color: #10243e;
            font-size: 32px;
        }

        .swagger-header p {
            margin: 0;
            color: #52637a;
            font-size: 15px;
        }

        #swagger-ui {
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(16, 36, 62, 0.12);
        }
    </style>
</head>
<body>
<main class="swagger-shell">
    <section class="swagger-header">
        <h1>internetMyShop API</h1>
        <p>Swagger UI for the current API-first contract of the project.</p>
    </section>
    <section id="swagger-ui"></section>
</main>

<script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
<script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-standalone-preset.js"></script>
<script>
    window.addEventListener('load', function () {
        window.ui = SwaggerUIBundle({
            url: @json($specUrl),
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: 'StandaloneLayout',
            displayRequestDuration: true,
            tryItOutEnabled: true,
        });
    });
</script>
</body>
</html>
