<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jhon Jairo Tequia Rojas · Software Developer</title>

    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased">

<div class="mx-auto max-w-6xl px-6">

    {{-- Header --}}
    <header class="flex items-center justify-between py-8">

        <a href="/" class="text-lg font-bold tracking-tight">
            tequia.dev
        </a>

        <nav class="hidden gap-8 text-sm text-zinc-400 md:flex">
            <a href="#about" class="hover:text-white transition">Sobre mí</a>
            <a href="#projects" class="hover:text-white transition">Proyectos</a>
            <a href="#contact" class="hover:text-white transition">Contacto</a>
        </nav>

    </header>

    {{-- Hero --}}
    <section class="flex min-h-[75vh] items-center">

        <div class="max-w-3xl">

            <span class="rounded-full border border-zinc-800 px-3 py-1 text-xs uppercase tracking-[0.25em] text-zinc-400">
                Software Developer
            </span>

            <h1 class="mt-8 text-5xl font-black leading-tight md:text-7xl">
                Hola, soy
                <span class="text-white">
                    Jhon Jairo Tequia Rojas.
                </span>
            </h1>

            <p class="mt-8 text-xl leading-relaxed text-zinc-400">
                Desarrollador de software apasionado por construir aplicaciones
                escalables, explorar nuevas tecnologías y convertir ideas en
                productos reales utilizando Laravel, PHP y tecnologías web modernas.
            </p>

            <div class="mt-10 flex flex-wrap gap-4">

                <a href="#projects"
                   class="rounded-lg bg-white px-6 py-3 font-medium text-black transition hover:bg-zinc-200">
                    Ver proyectos
                </a>

                <a href="https://github.com/xenthrall"
                   target="_blank"
                   class="rounded-lg border border-zinc-700 px-6 py-3 font-medium hover:border-zinc-500">
                    GitHub
                </a>

            </div>

        </div>

    </section>

    {{-- Sobre mí --}}
    <section id="about" class="py-24">

        <h2 class="text-3xl font-bold">
            Sobre mí
        </h2>

        <p class="mt-8 max-w-3xl text-lg leading-8 text-zinc-400">
            Actualmente me especializo en el desarrollo backend con Laravel,
            diseñando aplicaciones modulares y fáciles de mantener.
            Disfruto aprender constantemente sobre arquitectura de software,
            inteligencia artificial, automatización, infraestructura y tecnologías
            cloud.
        </p>

        <p class="mt-6 max-w-3xl text-lg leading-8 text-zinc-400">
            Me gusta crear herramientas que resuelvan problemas reales y construir
            proyectos que puedan evolucionar con el tiempo mediante una buena
            arquitectura y código limpio.
        </p>

        <div class="mt-12 flex flex-wrap gap-3">

            @foreach([
                'Laravel',
                'PHP',
                'Filament',
                'PostgreSQL',
                'Redis',
                'Docker',
                'Linux',
                'Cloudflare',
                'Git',
                'Tailwind CSS',
                'Vue.js'
            ] as $tech)

                <span class="rounded-full border border-zinc-800 px-4 py-2 text-sm text-zinc-300">
                    {{ $tech }}
                </span>

            @endforeach

        </div>

    </section>

    {{-- Proyectos --}}
    <section id="projects" class="py-24">

        <h2 class="text-3xl font-bold">
            Proyectos
        </h2>

        <div class="mt-12 grid gap-8">

            <article class="rounded-2xl border border-zinc-800 bg-zinc-900/40 p-8">

                <div class="flex items-center justify-between">

                    <h3 class="text-2xl font-bold">
                        Atlas
                    </h3>

                    <span class="rounded-full border border-emerald-800 bg-emerald-950 px-3 py-1 text-xs text-emerald-400">
                        En desarrollo
                    </span>

                </div>

                <p class="mt-6 leading-8 text-zinc-400">
                    Atlas es mi plataforma personal. Nació como este portafolio,
                    pero su objetivo es convertirse en el lugar donde centralizo
                    todos mis proyectos, ideas, herramientas y experimentos.
                </p>

                <p class="mt-4 leading-8 text-zinc-400">
                    Cada nueva idea podrá evolucionar hasta convertirse en un
                    módulo independiente dentro del mismo ecosistema.
                </p>

            </article>

        </div>

    </section>

    {{-- Contacto --}}
    <section id="contact" class="py-24">

        <h2 class="text-3xl font-bold">
            Contacto
        </h2>

        <p class="mt-6 max-w-2xl text-lg text-zinc-400">
            Siempre estoy abierto a nuevas oportunidades, colaboraciones y
            conversaciones sobre desarrollo de software.
        </p>

        <div class="mt-10 flex flex-wrap gap-6 text-zinc-300">

            <a href="https://github.com/xenthrall" target="_blank" class="hover:text-white">
                GitHub
            </a>

            <a href="https://tequia.dev" class="hover:text-white">
                tequia.dev
            </a>

            <span>
                Colombia 🇨🇴
            </span>

        </div>

    </section>

    <footer class="border-t border-zinc-900 py-10 text-sm text-zinc-500">

        <div class="flex flex-col justify-between gap-4 md:flex-row">

            <div>
                © {{ now()->year }} Jhon Jairo Tequia Rojas
            </div>

            <div>
                Desarrollado con Laravel · Construido sobre Atlas
            </div>

        </div>

    </footer>

</div>

</body>
</html>