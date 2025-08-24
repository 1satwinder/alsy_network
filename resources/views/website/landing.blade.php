<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ settings('company_name') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="shortcut icon" href="{{ settings()->getFileUrl('favicon', asset(env('FAVICON', '/images/favicon.png'))) }}">
    <link rel="stylesheet" type="text/css"
          href="https://colorlib.com/etc/cs/comingsoon_04/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cs/comingsoon_04/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css"
          href="https://colorlib.com/etc/cs/comingsoon_04/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cs/comingsoon_04/css/util.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cs/comingsoon_04/css/main.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <style>
        :root {
            --primary: {{ settings('primary_color') }};
            --primary-hover: {{ settings('primary_color_hover') }};
        }

        body {
            overflow: hidden;
        }

        .logo {
            max-width: 400px;
            max-height: 200px;
            margin-bottom: 5rem;
        }

        .l1-txt2 {
            font-family: Montserrat-Light;
            font-size: 30px;
            color: #323232;
            line-height: 1.2;
        }

        .l1-txt1 {
            font-family: Montserrat-Black;
            font-size: 50px;
            color: #323232;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .how-countdown {
            background-color: #e9e9e9;
            border-radius: 18px;
            margin: 0 18px 25px;
        }

        canvas {
            display: block;
            vertical-align: center;
        }


        /* ---- stats.js ---- */

        .count-particles {
            position: absolute;
            top: 48px;
            left: 0;
            right: 0;
            color: #13E8E9;
            font-size: .8em;
            text-align: center;
            text-indent: 4px;
            line-height: 14px;
            padding-bottom: 2px;
        }

        .js-count-particles {
            font-size: 1.1em;
        }

        #stats,
        .count-particles {
            -webkit-user-select: none;
            margin-top: 5px;
            margin-left: 5px;
        }

        #stats {
            border-radius: 3px 3px 0 0;
            overflow: hidden;
        }

        .count-particles {
            border-radius: 0 0 3px 3px;
        }


        /* ---- particles.js container ---- */

        #particles-js {
            width: 100%;
            height: 100%;
            background-image: url('');
            background-size: cover;
            background-position: 50% 50%;
            background-repeat: no-repeat;
        }

        .btn {
            display: inline-block;
            font-weight: 600;
            text-transform: uppercase;
        }

        @media (max-width: 767.98px) {
            .l1-txt1 {
                font-size: 40px;
            }

            .l1-txt2 {
                font-family: Montserrat-Light;
                font-size: 20px;
                color: #323232;
                line-height: 1.2;
            }
        }
    </style>
</head>
<body>
<!-- particles.js container -->
<div id="particles-js"></div> <!-- stats - count particles -->
<div class="count-particles">
    <div class="size1 flex-w flex-col-c-sb p-l-15 p-r-15 p-t-55 p-b-35 respon1">
        <span></span>
        <div class="flex-col-c p-t-50 p-b-50">
            <div class="l1-txt1 txt-center p-b-10">
                <img class="logo" src="{{ settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png'))) }}" alt="">
            </div>
            <h3 class="l1-txt1 txt-center p-b-10">
                Coming Soon
            </h3>
            <div class="txt-center l1-txt2 p-b-60">
                <a href="{{ route('member.login.create') }}" class="btn btn-lg btn-primary">Login</a>
                <a href="{{ route('member.register.create') }}" class="btn btn-lg btn-outline-primary">Register</a>
            </div>
            <div class="flex-w flex-c cd100 p-b-82">
                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt3 p-b-9 days">0</span>
                    <span class="s1-txt1">Days</span>
                </div>
                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt3 p-b-9 hours">0</span>
                    <span class="s1-txt1">Hours</span>
                </div>
                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt3 p-b-9 minutes">0</span>
                    <span class="s1-txt1">Minutes</span>
                </div>
                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt3 p-b-9 seconds">0</span>
                    <span class="s1-txt1">Seconds</span>
                </div>
            </div>
        </div>
        <span class="s1-txt3 txt-center">
        © Copyright {{ date('Y') }} All rights reserved by {{ settings('company_name') }}.
    </span>
    </div>

</div>

<script src="https://colorlib.com/etc/cs/comingsoon_04/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="https://colorlib.com/etc/cs/comingsoon_04/vendor/bootstrap/js/popper.js"></script>
<script src="https://colorlib.com/etc/cs/comingsoon_04/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://colorlib.com/etc/cs/comingsoon_04/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script src="https://threejs.org/examples/js/libs/stats.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": {"value": 80, "density": {"enable": true, "value_area": 800}},
            "color": {"value": "#ecbf99"},
            "shape": {
                "type": "circle",
                "stroke": {"width": 0, "color": "#000000"},
                "polygon": {"nb_sides": 5},
                "image": {"src": "img/github.svg", "width": 100, "height": 100}
            },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": {"enable": false, "speed": 1, "opacity_min": 0.1, "sync": false}
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {"enable": false, "speed": 40, "size_min": 0.1, "sync": false}
            },
            "line_linked": {"enable": true, "distance": 150, "color": "#ecbf99", "opacity": 0.4, "width": 1},
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {"enable": false, "rotateX": 600, "rotateY": 1200}
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {"enable": true, "mode": "repulse"},
                "onclick": {"enable": true, "mode": "push"},
                "resize": true
            },
            "modes": {
                "grab": {"distance": 400, "line_linked": {"opacity": 1}},
                "bubble": {"distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3},
                "repulse": {"distance": 200, "duration": 0.4},
                "push": {"particles_nb": 4},
                "remove": {"particles_nb": 2}
            }
        },
        "retina_detect": true
    });
    var count_particles, stats, update;
    stats = new Stats;
    stats.setMode(0);
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.left = '0px';
    stats.domElement.style.top = '0px';
    document.body.appendChild(stats.domElement);
    count_particles = document.querySelector('.js-count-particles');
    update = function () {
        stats.begin();
        stats.end();
        if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
            count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
        }
        requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
    ;
</script>
<script>
    const daysEl = $('.days');
    const hoursEl = $('.hours');
    const minutesEl = $('.minutes');
    const secondsEl = $('.seconds');
    const launchMoment = moment('2024-03-05 18:00:00+05:30');

    const countDownInterval = setInterval(() => {
        let duration = moment.duration(launchMoment.diff());

        if (duration <= 0) {
            daysEl.html('0');
            hoursEl.html('0');
            minutesEl.html('0');
            secondsEl.html('0');

            clearInterval(countDownInterval);
        } else {
            let seconds = duration.seconds();
            let minutes = duration.minutes();

            daysEl.html(duration.days());
            hoursEl.html(duration.hours());
            minutesEl.html(minutes >= 10 ? minutes : `0${minutes}`);
            secondsEl.html(seconds >= 10 ? seconds : `0${seconds}`);
        }
    }, 1000);
</script>

</body>
</html>
