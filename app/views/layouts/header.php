<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'FutsalKit - Tournament Manager'; ?></title>
    <!-- Tailwind CSS v3 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        neon:   { DEFAULT: '#22c55e', light: '#4ade80', dark: '#16a34a' },
                        surface: { DEFAULT: '#111827', card: '#1f2937', border: '#374151', hover: '#273344' },
                    },
                    fontFamily: {
                        sans: ['Outfit', 'ui-sans-serif', 'system-ui'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-in': 'slideIn 0.3s ease-out',
                    },
                    keyframes: {
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons (keeping icons only) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { font-family: 'Outfit', sans-serif; }
        body { background-color: #111827; }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #22c55e; }
        /* Sidebar transition */
        #sidebar { transition: transform 0.3s ease; }
        #overlay { transition: opacity 0.3s ease; }
        /* Neon glow */
        .neon-glow { box-shadow: 0 0 20px rgba(34,197,94,0.25); }
        /* Active nav */
        .nav-active { background-color: rgba(34,197,94,0.15); border-left: 3px solid #22c55e; color: #4ade80; }
    </style>
</head>
<body class="h-screen flex overflow-hidden bg-gray-900 text-gray-100">

<!-- ========== MOBILE OVERLAY ========== -->
<div id="overlay" class="fixed inset-0 bg-black/60 z-20 hidden opacity-0 lg:hidden" onclick="closeSidebar()"></div>

<!-- ========== SIDEBAR ========== -->
<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-30 w-64 flex-shrink-0 flex flex-col bg-gray-900 border-r border-gray-700/60 transform -translate-x-full lg:translate-x-0 h-screen">
    <!-- Brand -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-gray-700/60">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg neon-glow">
            <i class="bi bi-dribbble text-black font-bold text-lg"></i>
        </div>
        <div>
            <span class="text-lg font-extrabold bg-gradient-to-r from-green-400 to-emerald-300 bg-clip-text text-transparent tracking-tight">FutsalKit</span>
            <span class="block text-[10px] text-gray-500 uppercase tracking-widest -mt-0.5">Tournament Manager</span>
        </div>
        <!-- Close button (mobile) -->
        <button onclick="closeSidebar()" class="ml-auto lg:hidden text-gray-400 hover:text-white p-1">
            <i class="bi bi-x-lg text-xl"></i>
        </button>
    </div>

    <!-- User info -->
    <?php if (Session::isLoggedIn()): ?>
    <div class="px-4 py-3 border-b border-gray-700/60 bg-gray-800/40">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-600 to-teal-600 flex items-center justify-center text-sm font-bold text-white flex-shrink-0">
                <?php echo strtoupper(substr(Session::get('user_name'), 0, 1)); ?>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-white truncate"><?php echo htmlspecialchars(Session::get('user_name')); ?></p>
                <span class="text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded-full <?php echo Session::isAdmin() ? 'bg-green-500/20 text-green-400' : 'bg-blue-500/20 text-blue-400'; ?>">
                    <?php echo Session::get('user_role'); ?>
                </span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Nav Links -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <?php if (Session::isLoggedIn()): ?>
            <?php
                $uri = $_SERVER['REQUEST_URI'];
                $isDash    = strpos($uri, '/dashboard') !== false || ($uri === '/' . basename(dirname($_SERVER['SCRIPT_NAME'])) . '/');
                $isTeam    = strpos($uri, '/team') !== false;
                $isPlayer  = strpos($uri, '/player') !== false;
                $isMatch   = strpos($uri, '/match') !== false;
            ?>
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-semibold px-3 mb-2">Menu</p>

            <a href="<?php echo BASE_URL; ?>/dashboard"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo $isDash ? 'nav-active' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <i class="bi bi-speedometer2 text-base w-5 text-center"></i> Dashboard
            </a>

            <a href="<?php echo BASE_URL; ?>/teams"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo $isTeam ? 'nav-active' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <i class="bi bi-shield-shaded text-base w-5 text-center"></i>
                <?php echo Session::isAdmin() ? 'Daftar Tim' : 'Tim Saya'; ?>
            </a>

            <?php if (Session::isManager()): ?>
            <a href="<?php echo BASE_URL; ?>/players"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo $isPlayer ? 'nav-active' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <i class="bi bi-people text-base w-5 text-center"></i> Pemain
            </a>
            <?php endif; ?>

            <a href="<?php echo BASE_URL; ?>/matches"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo $isMatch ? 'nav-active' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <i class="bi bi-calendar-event text-base w-5 text-center"></i> Jadwal Pertandingan
            </a>

        <?php endif; ?>
    </nav>

    <!-- Logout -->
    <?php if (Session::isLoggedIn()): ?>
    <div class="px-3 py-4 border-t border-gray-700/60">
        <a href="<?php echo BASE_URL; ?>/logout"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
            <i class="bi bi-box-arrow-left text-base w-5 text-center"></i> Logout
        </a>
    </div>
    <?php endif; ?>
</aside>

<!-- ========== MAIN CONTENT AREA ========== -->
<div class="flex-1 flex flex-col min-w-0 overflow-hidden">

    <!-- Top Bar (mobile hamburger + page context) -->
    <header class="flex items-center gap-4 px-4 sm:px-6 py-3 bg-gray-900 border-b border-gray-700/60 flex-shrink-0">
        <!-- Hamburger (mobile) -->
        <button onclick="openSidebar()" class="lg:hidden text-gray-400 hover:text-white p-1 -ml-1">
            <i class="bi bi-list text-2xl"></i>
        </button>

        <!-- Page title via breadcrumb feel -->
        <div class="flex items-center gap-2 min-w-0">
            <span class="text-sm text-gray-500 hidden sm:inline">FutsalKit</span>
            <i class="bi bi-chevron-right text-gray-600 text-xs hidden sm:inline"></i>
            <span class="text-sm font-semibold text-white truncate"><?php echo isset($title) ? explode(' |', $title)[0] : 'Dashboard'; ?></span>
        </div>

        <div class="ml-auto flex items-center gap-3">
            <!-- UAS Badge -->
            <span class="hidden sm:inline text-[10px] uppercase tracking-widest font-bold px-2 py-1 rounded-full border border-green-500/30 text-green-400 bg-green-500/10">
                UAS PWD 2026
            </span>
        </div>
    </header>

    <!-- Scrollable content wrapper -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6">

        <!-- Flash Messages -->
        <?php foreach (['success', 'danger', 'warning', 'info'] as $type):
            if (!Session::hasFlash($type)) continue;
            $styles = [
                'success' => ['bg-green-500/10 border-green-500/30 text-green-300', 'bi-check-circle-fill text-green-400'],
                'danger'  => ['bg-red-500/10 border-red-500/30 text-red-300',   'bi-exclamation-triangle-fill text-red-400'],
                'warning' => ['bg-yellow-500/10 border-yellow-500/30 text-yellow-300', 'bi-exclamation-circle-fill text-yellow-400'],
                'info'    => ['bg-blue-500/10 border-blue-500/30 text-blue-300',  'bi-info-circle-fill text-blue-400'],
            ];
        ?>
        <div class="flex items-start gap-3 mb-5 px-4 py-3 rounded-xl border <?php echo $styles[$type][0]; ?> text-sm relative" role="alert">
            <i class="bi <?php echo $styles[$type][1]; ?> mt-0.5 flex-shrink-0"></i>
            <span><?php echo Session::getFlash($type); ?></span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-current opacity-50 hover:opacity-100 flex-shrink-0">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <?php endforeach; ?>

