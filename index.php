<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Roomzy</title>
        <link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/firstask.css">

    </head>
    <body>
        
    
        <?php include_once 'php/navbar.php'; ?>

        <main> <!--there is change here -->
            
        <!--section to tell user what system for-->
        <section id="about-us"  class="py-5">
            <div class="container   ">
                <h2 class="text-center mb-4">About Us</h2>

                <div class="row align-item-center">
                    <div class="col-md-6">
                        <h3>Who We Are</h3>
                        <p>
                            imagine a place where booking a room is easy as clicking a button. At <strong> IT Collage Room Booking</strong>,we are 
                            revolutionizing how students and staff connect with campus facilities . No more waiting or confusing schedules- just simple, efficient room management tailored for  needs.
                        </p>
                        <blockquote class="blockquote">
                            "Our mission is to create a seamless experience that empowers students and staff to foucs on what matters most."
                        </blockquote>
                    </div>
                    <div class="col-md-6">
                        <img src="https://i.pinimg.com/736x/30/f7/52/30f752480cc20f0d668cf670f098ca6d.jpg" alt="Who We Are" class="img-fluid rounded shadow">

                    </div>
                </div>
                <!--interactive timeline-->
                <div class="timeline mt-5">
                    <h3 class="text-center mb-4">Our Journey</h3>
                    <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="timeline-card p-4 bg-light shadow-sm rounded">
                            <h4>2020</h4>
                            <p>We started with vision: to simplify campus resource management.</p>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <div class="timeline-card p-4 bg-light shadow-sm rounded">
                            <h4>2022</h4>
                            <p>Lunched the first version of the room booking system.</p>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <div class="timeline-card p-4 bg-light shadow-sm rounded">
                            <h4>2024</h4>
                            <p>Enhanced the platform with modern features and responsive design.</p>
                        </div>
                    </main> <!--there is change here -->
                    </div>
                </div>
            </div>

            <div class="row mt-5 text-center">
                <h3 class="mb-4">Why Choose Us?</h3>
                <div class="col-md-4">
                    <div class="fact-card p-4 bg-cs text-block rounded">
                        <h4>1,000+</h4>
                        <p>Room Booked Monthly</p>
                    </div>
                </div>
                 
                     <div class="col-md-4">
                        <div class="fact-card p-4 bg-is text-block rounded">
                            <h4>500+</h4>
                            <p>Satisfied Students & Staff</p>
                        </div>
                    </div>
                     
                         <div class="col-md-4">
                            <div class="fact-card p-4 bg-ce text-block rounded">
                                <h4>3</h4>
                                <p>Departments Supported </p>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="hero text-center py-5">
                    <div class="container">
                        <h2 class="hero-title">Book Your Rooms Seamlessly</h2>
                        <p class="hero-subtitle">Efficient and user-friendly room booking for IT collage student and staff.</p>
                        <a href="php/login.php" class="btn btn-dark btn-lg mt-3">Get Started</a>
                    </div>
                </section>

                <!--feauters section-->
                <section id="features" class="py-5">
                    <div class="container text-center">
                        <h3 class="mb-4">Features</h3>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="features-card features-cs ">
                                  <h4  >CS Department </h4>
                                  <p>Book rooms for computer science classes and workshop.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="features-card features-is">
                                    <h4>IS Department </h4>
                                    <p>Reserve space for information systems projects and labs.</p>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="features-card features-ce ">
                                    <h4>CE Department </h4>
                                    <p>Find room for computer engineering lectures and events.</p>
                               
                                </div>
                            </div>
                        </div> 
                    </div>
                </section>

                <!--contact section-->
                <section id="contact" class="py-5">
                    <div class="container text-center">
                        <h3 class="mb-4">Contact Us</h3>
                        <form class="row g-3 justify-content-center">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type=" email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-dark" >Send Message</button>
                            </div>
                        </form>
                    </div>
                </section>
                <!--footer-->
                <footer class="footer py-3">
                    <div class="text-center">
                        <p>&copy; 2024 IT Collage Room Booking System. All rights reserved.</p>
                    </div>
                </footer>

            
            

        </section>

    </body>


</html>
