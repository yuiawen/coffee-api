<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <title><?= $this->renderSection('title') ?></title>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <div class="flex">
        <aside class="w-64 h-screen bg-white shadow-md sticky top-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-sky-600">Caffè Lento</h1>
                <p class="text-sm text-slate-500">Admin Panel</p>
            </div>
            <nav class="mt-6">
                <a href="/" class="block py-2.5 px-6 text-slate-700 hover:bg-sky-100 hover:text-sky-600 transition-colors duration-200">
                    Dashboard
                </a>
                <a href="/coffees" class="block py-2.5 px-6 text-slate-700 hover:bg-sky-100 hover:text-sky-600 transition-colors duration-200">
                    Manajemen Kopi
                </a>
                <a href="/foods" class="block py-2.5 px-6 text-slate-700 hover:bg-sky-100 hover:text-sky-600 transition-colors duration-200">
                    Manajemen Makanan
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

</body>
</html>