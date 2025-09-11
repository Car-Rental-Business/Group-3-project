<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php?redirect=booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/booking.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navdiv">
                <div class="logo"><a href="index.html">RENTAL</a></div>
                <ul class="nav_links">
                    <li><a href="#" class="btn">Home</a></li>
                    <li><a href="rent.html">Rent Date</a></li>
                    <li><a href="collection.html">Cars</a></li>
                    <li><a href="payment.html">Payment</a></li>
                    <li><a href="#contact">Contact</a></li>
        </nav>
    </header>

    <main class="booking-container">
        <h2>Complete Your Booking</h2>
        <div id="selected-car" class="selected-car"></div>
        
        <form id="booking-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Delivery Address (if applicable)</label>
                <input type="text" id="address">
            </div>
            <div class="form-group">
                <label for="notes">Special Requests</label>
                <textarea id="notes" rows="3"></textarea>
            </div>

            <div>
                <p id="modal-title"></p>
            </div>
            <button type="submit" class="btn">Confirm Booking</button>
        </form>
    </main>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <h3 id="modal-title">Booking Confirmed!</h3>
            <p id="modal-message"></p>
            <button class="btn" id="modal-close">Return to Home</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get selected car from localStorage
            const car = JSON.parse(localStorage.getItem('selectedCar'));
            const bookingForm = document.getElementById('booking-form');
            const modal = document.getElementById('confirmation-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            const modalClose = document.getElementById('modal-close');
            
            // Display selected car details
            if (car) {
                document.getElementById('selected-car').innerHTML = `
                    <img src="${car.image}" alt="${car.name}">
                    <h3>${car.name}</h3>
                    <p>${car.price}</p>
                    <p>${car.specs || ''}</p>
                `;
            } else {
                // If no car selected, redirect to home
                window.location.href = 'index.html';
            }
            
            // Form submission
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form values
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;
                
                // Validate form
                if (!name || !email || !phone) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                // Simple email validation
                if (!email.includes('@') || !email.includes('.')) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                // Save booking data (in a real app, you would send this to a server)
                const bookingData = {
                    car: car,
                    customer: {
                        name: name,
                        email: email,
                        phone: phone,
                        address: document.getElementById('address').value,
                        notes: document.getElementById('notes').value
                    },
                    bookingDate: new Date().toLocaleDateString()
                };
                
                localStorage.setItem('bookingData', JSON.stringify(bookingData));
                
                // Show confirmation modal
                modalTitle.textContent = 'Booking Confirmed!';
                modalMessage.textContent = `Thank you, ${name}! Your booking for the ${car.name} has been confirmed. We've sent the details to ${email}.`;
                modal.style.display = 'flex';
            });
            
            // Close modal and redirect
            modalClose.addEventListener('click', function() {
                localStorage.removeItem('selectedCar');
                window.location.href = 'index.html';
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    localStorage.removeItem('selectedCar');
                    window.location.href = 'index.html';
                }
            });
        });
    </script>
</body>
</html>