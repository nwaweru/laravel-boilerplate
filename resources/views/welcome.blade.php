<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/miri/favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body>
    <header class="miri-ui-kit-header landing-header header-bg-2">
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-on-scroll">
            <div class="container">
                <a class="navbar-brand" href="index.html"><img src="{{ asset('img/miri/logo.svg') }}" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#miriUiKitNavbar"
                    aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="mdi mdi-menu"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="miriUiKitNavbar">
                    <div class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="http://bootstrapdash.com/demo/miri-ui-kit-pro/documentation/documentation.html" target="_blank">Docs</span></a>
                        </li>
            
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">UI Kits</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                Example Pages
                            </a>
                            <div class="dropdown-menu dropdown-menu-right ">
                                <a href="landing.html" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-shape-outline"></i>Landing Page</a>
                                <a href="login.html" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-lock-outline"></i>Login Page</a>
                                <a href="profile.html" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-shield-account-outline"></i>Profile Page</a>
                            </div>
                        </li>
            
                        <li class="nav-item">

                            <a class="nav-link nav-icon icon-fb" href="#"><i class="mdi mdi-facebook-box"></i></a>

                            <a class="nav-link nav-icon icon-twitter" href="#"><i class="mdi mdi-twitter-box"></i></a>
    
                            <a class="nav-link nav-icon icon-insta" href="#"><i class="mdi mdi-instagram"></i></a>
                            
                        </li>
            
                        <form action="#" class="form-inline ml-lg-3">
                            <button class="btn btn-danger">Download Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <div
            class="miri-ui-kit-header-content text-center text-white d-flex flex-column justify-content-center align-items-center">
            <h1 class="display-3 text-white">Landing Page</h1>
            <p class="h3 font-weight-light text-white">A beautiful premium bootstrap 4 developed by bootstrapdash.</p>
            <p class="mt-4">
                <button class="btn btn-danger btn-pill mr-2">Watch Video</button>
                <button class="btn btn-success btn-pill">Purchase Now</button>
            </p>
        </div>
    </header>

    <section class="miri-ui-kit-section mt-5">
        <div class="container">
            <div class="d-md-flex justify-content-between row">

                <div class="feature-box px-3">
                    <span class="card-icon bg-danger text-white rounded-circle"><i class="mdi mdi-bell"></i></span>
                    <h3 class="mb-3">Prototyping</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.</p>
                </div>


                <div class="feature-box px-3">
                    <span class="card-icon bg-success text-white rounded-circle"><i
                            class="mdi mdi-heart-outline"></i></span>
                    <h3 class="mb-3">Branding</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.</p>
                </div>


                <div class="feature-box px-3">
                    <span class="card-icon bg-primary text-white rounded-circle"><i class="mdi mdi-vibrate"></i></span>
                    <h3 class="mb-3">Development</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.</p>
                </div>

            </div>
        </div>
    </section>
    <section class="miri-ui-kit-section how-we-work-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-warning mb-3">HOW WE WORK</h5>
                        <h2 class="h1 font-weight-semibold mb-4">Achieve virtually any design and layout from within the
                            one template. </h2>
                        <p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed esse doloremque
                            nostrum, fuga fugit minima quod delectus magni explicabo quis aliquam laborum molestiae sint
                            voluptatum ea beatae sunt rerum! Saepe.</p>
                        <p><button class="btn btn-rounded btn-danger raise-on-hover" data-toggle="lightbox" data-target="#demoVideoLightbox"><i class="mdi mdi-play"></i></button><span
                                class="button-label text-danger font-weight-medium ml-3">SEE HOW WE WORKS</span></p>
                </div>
                <div class="col-md-6 d-md-flex justify-content-end">
                    <div class="card bg-dark text-white count-card">
                        <img src="{{ asset('img/miri/count-card-bg.jpg') }}" alt="about 1" class="card-img">
                        <div class="card-img-overlay">
                            <div class="count-box bg-success text">
                                <span class="h2 text-white">30K</span>
                                <span class="font-weight-medium">Download</span>
                            </div>
                            <div class="count-box bg-danger">
                                <span class="h2 text-white">3323</span>
                                <span class="font-weight-medium">Customers</span>
                            </div>
                            <div class="count-box bg-warning">
                                <span class="h2 text-white">53,981</span>
                                <span class="font-weight-medium">Revenue</span>
                            </div>
                            <div class="count-box bg-primary">
                                <span class="h2 text-white">3422</span>
                                <span class="font-weight-medium">Orders</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="miri-ui-kit-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex flex-column justify-content-center">
                    <h6 class="text-warning mb-3">About us</h5>
                        <h2 class="h1 font-weight-semibold mb-4">Meet our business partner who work behind the scene.
                        </h2>
                        <p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed esse doloremque
                            nostrum, fuga fugit minima quod delectus magni explicabo quis aliquam laborum molestiae sint
                            voluptatum ea beatae sunt rerum! Saepe.</p>
                        <p><button class="btn btn-primary">Learn more</button></p>
                </div>
                <div class="col-md-6 text-right"><img src="{{ asset('img/miri/about.png') }}" alt="About" class="img-fluid"></div>
            </div>
        </div>
    </section>
    <Section class="miri-ui-kit-section team-members-section">
        <div class="container">
            <h2 class="pb-2 mb-5">Team Members</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-card card border-0 raise-on-hover">
                        <img src="{{ asset('img/miri/team-1.jpg') }}" alt="Team 1" class="card-img-top">
                        <div class="card-body px-0">
                            <h5 class="card-title mb-0">Afonso Pinto</h5>
                            <p class=" font-weight-medium designation">Founded & Chairman</p>
                            <p>Achieve virtually any design and layout from with in the</p>
                            <p class="social-links">
                                <a href="#" class="icon-fb"><i class="mdi mdi-facebook-box"></i></a>
                                <a href="#" class="icon-twitter"><i class="mdi mdi-twitter-box"></i></a>
                                <a href="#" class="icon-insta"><i class="mdi mdi-instagram"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-card card border-0 raise-on-hover">
                        <img src="{{ asset('img/miri/team-2.jpg') }}" alt="Team 2" class="card-img-top">
                        <div class="card-body px-0">
                            <h5 class="card-title mb-0">Irene Sotelo</h5>
                            <p class=" font-weight-medium designation">Frontend Developer</p>
                            <p>Achieve virtually any design and layout from with in the</p>
                            <p class="social-links">
                                <a href="#" class="icon-fb"><i class="mdi mdi-facebook-box"></i></a>
                                <a href="#" class="icon-twitter"><i class="mdi mdi-twitter-box"></i></a>
                                <a href="#" class="icon-insta"><i class="mdi mdi-instagram"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-card card border-0 raise-on-hover">
                        <img src="{{ asset('img/miri/team-3.jpg') }}" alt="Team 3" class="card-img-top">
                        <div class="card-body px-0">
                            <h5 class="card-title mb-0">Marama Petera</h5>
                            <p class=" font-weight-medium designation">Designer & Creative Director</p>
                            <p>Achieve virtually any design and layout from with in the</p>
                            <p class="social-links">
                                <a href="#" class="icon-fb"><i class="mdi mdi-facebook-box"></i></a>
                                <a href="#" class="icon-twitter"><i class="mdi mdi-twitter-box"></i></a>
                                <a href="#" class="icon-insta"><i class="mdi mdi-instagram"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <section class="miri-ui-kit-section pricing-section">
        <div class="container">
            <h2>Choose Plan</h2>
            <p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <div class="card-group">
                <div class="card text-center">
                    <div class="card-body p-5">
                        <h4>Free</h4>
                        <p>Achieve virtually any design and layout from with in the</p>
                        <p>
                            <button class="btn btn-primary">ChoosePlan</button>
                        </p>
                    </div>
                </div>
                <div class="card text-center">
                    <div class="card-body p-5">
                        <h4>Premium</h4>
                        <p>Achieve virtually any design and layout from with in the</p>
                        <p>
                            <button class="btn btn-danger">ChoosePlan</button>
                        </p>
                    </div>
                </div>
                <div class="card text-center">
                    <div class="card-body p-5">
                        <h4>Business</h4>
                        <p>Achieve virtually any design and layout from with in the</p>
                        <p>
                            <button class="btn btn-success">ChoosePlan</button>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="miri-ui-kit-section contact-section">
        <div class="container">
            <h2 class="text-center mb-4">Work with us</h2>
            <p class="text-center mb-4 pb-3">If there is something we can help you with, just let us know. We'll <br />
                be more than happy to offer you our
                help.</p>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form action="/" class="contact-form">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control form-control-pill" placeholder="Default">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control form-control-pill"
                                    placeholder="Email@example.com">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control form-control-pill" placeholder="Contact-number">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="submit" value="Send Message" class="btn btn-block btn-pill btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer class="pt-5 mt-2">
        <div class="container">
            <section class="footer-content text-center">
                <h2 class="">Clean and simple theme built with Bootstrap 4</h2>
                <p>If there is something we can help you with, just let us know. We'll be more than happy to offer you
                    our help.</p>
                <button class="btn btn-success mt-3">Download Now</button>
                <p class="footer-social-links text-center my-4">
                    <a href="#" class="icon-fb"><i class="mdi mdi-facebook-box"></i></a>
                    <a href="#" class="icon-twitter"><i class="mdi mdi-twitter-box"></i></a>
                    <a href="#" class="icon-insta"><i class="mdi mdi-instagram"></i></a>
                    <a href="#" class="icon-behance"><i class="mdi mdi-behance"></i></a>
                    <a href="#" class="icon-dribbble"><i class="mdi mdi-dribbble-box"></i></a>
                    <a href="#" class="icon-github"><i class="mdi mdi-github-circle"></i></a>
                </p>
            </section>
            <nav class="navbar navbar-light bg-transparent navbar-expand d-block d-sm-flex text-center">
                <span class="navbar-text">&copy; BootstrapDash. All rights reserved.</span>
                <div class="navbar-nav ml-auto justify-content-center">
                    <a href="#" class="nav-link">Support</a>
                    <a href="#" class="nav-link">Terms</a>
                    <a href="#" class="nav-link">Privacy</a>
                </div>
            </nav>
        </div>
    </footer>
    <div id="demoVideoLightbox" class="lightbox" onclick="hideVideo('video','youtube')">
        <div class="lightbox-container">  
          <div class="lightbox-content">
            
            <button data-close="lightbox" class="lightbox-close">
              Close | ✕
            </button>
            <div class="video-container">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/eTlZLNws6zc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>      
            
          </div>
        </div>
      </div>
    <script src="{{ asset('js/landing.js') }}"></script>
</body>

</html>