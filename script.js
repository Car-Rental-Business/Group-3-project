document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('pickup-date').min = today;
    document.getElementById('end-date').min = today;
    
    // Calculate duration when dates change
    const pickupDate = document.getElementById('pickup-date');
    const endDate = document.getElementById('end-date');
    const durationDisplay = document.getElementById('rental-duration');
    
    pickupDate.addEventListener('change', updateDuration);
    endDate.addEventListener('change', updateDuration);
    
    function updateDuration() {
        const start = new Date(pickupDate.value);
        const end = new Date(endDate.value);
        
        if (pickupDate.value && endDate.value && start <= end) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            durationDisplay.textContent = `${diffDays} ${diffDays === 1 ? 'day' : 'days'}`;
            document.getElementById('date-error').textContent = '';
        } else if (pickupDate.value && endDate.value && start > end) {
            document.getElementById('date-error').textContent = 'Return date must be after pick-up date';
            durationDisplay.textContent = '0 days';
        } else {
            durationDisplay.textContent = '0 days';
        }
        
        // Update minimum end date based on pickup date
        if (pickupDate.value) {
            endDate.min = pickupDate.value;
        }
    }
    
    // Check availability button functionality
    document.getElementById('check-availability').addEventListener('click', function() {
        if (!pickupDate.value || !endDate.value) {
            document.getElementById('date-error').textContent = 'Please select both dates';
        } else if (new Date(pickupDate.value) > new Date(endDate.value)) {
            document.getElementById('date-error').textContent = 'Return date must be after pick-up date';
        } else {
            // Proceed with availability check
            window.location.href = `collection.html?pickup=${pickupDate.value}&return=${endDate.value}`;
        }
    });
});

 // Filter functionality
 document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', () => {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        
        const category = button.dataset.category;
        const cars = document.querySelectorAll('.car-card');
        
        cars.forEach(car => {
            if (category === 'all' || car.dataset.category === category) {
                car.style.display = 'block';
            } else {
                car.style.display = 'none';
            }
        });
    });
});

// Handle Rent & Buy Buttons
document.querySelectorAll('.buy-btn, .rent-btn').forEach(button => {
    button.addEventListener('click', () => {
        const carCard = button.closest('.car-card');
        const carName = carCard.querySelector('h3').textContent;
        const carPrice = carCard.querySelector('.price').textContent;
        const carImage = carCard.querySelector('img').getAttribute('src');
        const carSpecs = carCard.querySelector('.specs').textContent;

        // Save car details
        const selectedCar = {
            name: carName,
            price: carPrice,
            image: carImage,
            specs: carSpecs
        };
        localStorage.setItem('selectedCar', JSON.stringify(selectedCar));

        // Redirect based on button type
        if (button.classList.contains('rent-btn')) {
            window.location.href = "booking.html";  // Go to booking form
        } else {
            window.location.href = "buy.html";      // Go to buy page
        }
    });
});





        // Handle payment
        document.getElementById('payment-form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Payment successful!');
            localStorage.removeItem('booking');
            window.location.href = "index.php";
        });

// In your existing rent button event listener:
document.querySelectorAll('.rent-btn').forEach(button => {
    button.addEventListener('click', () => {
        const carCard = button.closest('.car-card');
        const carName = carCard.querySelector('h3').textContent;
        const carPrice = carCard.querySelector('.price').textContent;
        const carImage = carCard.querySelector('img').getAttribute('src');
        const carSpecs = carCard.querySelector('.specs').textContent;
        window.location.href = `rent.html?car=${encodeURIComponent(carName)}&price=${encodeURIComponent(carPrice)}&image=${encodeURIComponent(carImage)}&specs=${encodeURIComponent(carSpecs)}`;
    });
});



document.querySelectorAll('.payment-method').forEach(method => {
    method.addEventListener('click', function() {
      // Remove selected class from all methods
      document.querySelectorAll('.payment-method').forEach(m => {
        m.classList.remove('selected');
      });
      
      // Add selected class to clicked method
      this.classList.add('selected');
      
      // Hide all forms
      document.querySelectorAll('.checkout-form').forEach(form => {
        form.classList.remove('active');
      });
      
      // Show corresponding form
      const methodType = this.getAttribute('data-method');
      document.getElementById(`${methodType}Form`).classList.add('active');
    });
  });
