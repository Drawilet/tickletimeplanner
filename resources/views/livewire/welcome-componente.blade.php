<div>
<style>
    html{
        line-height:1.15;-webkit-text-size-adjust:100%
    }
    body{
        margin:0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    a{
     background-color:transparent
    }
    [hidden]{display:none}
    html{
        font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}
        a{
            color:inherit;text-decoration:inherit
        }
        .bg-white{
            background-color: #F7F9E3
        }
        .bg-gray-100{
            background-color:#F7F9E3
        }
        .border-gray-200{
            --tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))
        }
        .font-semibold{
            font-weight:600
        }
        .text-sm{font-size:.875rem}
        .text-lg{font-size:1.125rem}
        .leading-7{line-height:1.75rem}
        .ml-1{margin-left:.25rem}
        .mt-2{margin-top:.5rem}
        .mr-2{margin-right:.5rem}
        .ml-2{margin-left:.5rem}
        .mt-4{margin-top:1rem}
        .ml-4{margin-left:1rem}
        .mt-8{margin-top:2rem}
        .ml-12{margin-left:3rem}
        .-mt-px{margin-top:-1px}
        .max-w-6xl{max-width:72rem}
        .min-h-screen{min-height:100vh}
        .overflow-hidden{overflow:hidden}
        .p-6{padding:1.5rem}
        .py-4{padding-top:1rem;padding-bottom:1rem}
        .px-6{padding-left:1.5rem;padding-right:1.5rem}
        .pt-8{padding-top:2rem}
        .fixed{position:fixed}
        .relative{position:relative}
        .top-0{top:0}
        .right-0{right:0}
        
        .content-container {
            display: flex;
            max-width: 100%;
            
        }
        .text {
            flex: 1;
            padding: 10px;
            margin-right: 90px;
        }
        h1{
            max-width: 180px;
        }
      
        .image {
            margin-bottom: 20px;
            flex: 1;
            text-align: right;
            padding: 30px;
        }
        img {
            max-width: 300px;
            height: auto;
        }
            @media (min-width:640px)
            {.sm\:rounded-lg{border-radius:.5rem}
            .sm\:block{display:block}
            .sm\:items-center{align-items:center}
            .sm\:justify-start{justify-content:flex-start}
            .sm\:justify-between{justify-content:space-between}
            .sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}
            .sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}
            .sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}
            .sm\:text-right{text-align:right}}
           
    </style>
    <body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            @endauth
        </div>
        @endif 
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
           <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <img src="\newLogo.png" class="mr-5" width="200px" >
           </div>
           
         <div class="content-container">
             <div class="text">
                 <h1>Tickle Time Planner </h1> 
              
             <h2>Instant Reservations</h2>
                <p>Makes it easy for users to book quickly
                    and simple space for events,
                    whether for corporate meetings,
                    private parties or other occasions
                </p>
             <h2>Our services </h2>
                <p>we provide a comprehensive solution for reservation management,
                    appointments and events, with a friendly interface and functions that improve efficiency
                    and user satisfaction in the planning process.
                </p>
             </div>
            <div class="image mt-10">
                <img src="\bg-1.png"   alt="Imagen de Fondo">
            </div>
            
        </div>
    <label class="swap swap-rotate">
                <!-- this hidden checkbox controls the state -->
                <input type="checkbox" class="theme-controller" value="synthwave"
                    data-toggle-theme="corporate,business" />

                <!-- sun icon -->
                <svg class="swap-on fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                </svg>

                <!-- moon icon -->
                <svg class="swap-off fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                </svg>

            </label>
        </div>
        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </div>
    </div>
</body>
</div>
