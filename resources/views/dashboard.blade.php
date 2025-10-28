<x-app-layout>
    <x-slot name="title">Dashboard - Elchapo</x-slot>

    <style>
        .dashboard-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .welcome-text {
            font-weight: bold;
            color: white;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin: 0;
            
            /* Responsive font sizes */
            font-size: 2rem; /* Default for mobile */
        }

        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) {
            .welcome-text {
                font-size: 2.5rem;
            }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) {
            .welcome-text {
                font-size: 3rem;
            }
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) {
            .welcome-text {
                font-size: 3.5rem;
            }
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
            .welcome-text {
                font-size: 4rem;
            }
        }

        /* Extra extra large devices (4K screens, 1600px and up) */
        @media (min-width: 1600px) {
            .welcome-text {
                font-size: 5rem;
            }
        }

        /* Very small devices (phones under 400px) */
        @media (max-width: 400px) {
            .welcome-text {
                font-size: 1.75rem;
                line-height: 1.3;
            }
        }

        /* Prevent text from getting too wide on large screens */
        @media (min-width: 768px) {
            .welcome-text {
                max-width: 80%;
            }
        }

        /* Landscape mode on mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .dashboard-bg {
                padding: 0.5rem;
                min-height: calc(100vh - 100px);
            }
            .welcome-text {
                font-size: 2rem;
            }
        }

        /* High DPI screens */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .welcome-text {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        }

        /* Print styles */
        @media print {
            .dashboard-bg {
                background: white !important;
            }
            .welcome-text {
                color: black !important;
                text-shadow: none;
            }
        }
    </style>

    <div class="dashboard-bg">
        <p class="welcome-text">Welcome to Elchapo</p>
    </div>
</x-app-layout>