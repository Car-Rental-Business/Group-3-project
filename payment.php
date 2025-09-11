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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/payment.css">
    <title>Secure Payment</title>
</head>
<body>
     <header>
            <div class="navbar">
                <div class="navdiv">
                    <div class="logo"><a href="index.php">RENTAL</a></div>
                    <ul class="nav_links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="rent.html">Rent Date</a></li>
                        <li><a href="collection.html">Cars</a></li>
                        <li><a href="payment.php">Payment</a></li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li><a href="auth/logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="auth/login.php">Login</a></li>
                            <li><a href="auth/signup.php">Signup</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>            
        </header>
    
    <!-- Modern Payment Section -->
    <section id="payment">
        <div class="payment-container">
            <div class="payment-header">
                <h2 class="payment-title">Secure Payment</h2>
                <p class="payment-subtitle">Complete your booking with confidence</p>
            </div>
            
            <div class="payment-grid">
                <!-- Payment Methods Selector -->
                <div class="payment-methods">
                    <div class="payment-method active" data-method="card" onclick="selectPaymentMethod('card')">
                        <div class="method-icon">
                            <i class="ri-bank-card-line"></i>
                        </div>
                        <div class="method-info">
                            <h3>Credit/Debit Card</h3>
                            <p>Visa, Mastercard, Amex</p>
                        </div>
                        <div class="method-selector"></div>
                    </div>
                    
                    <div class="payment-method" data-method="wallet" onclick="selectPaymentMethod('wallet')">
                        <div class="method-icon">
                            <i class="ri-smartphone-line"></i>
                        </div>
                        <div class="method-info">
                            <h3>Mobile Wallets</h3>
                            <p>Apple Pay, Google Pay</p>
                        </div>
                        <div class="method-selector"></div>
                    </div>
                    
                    <div class="payment-method" data-method="paypal" onclick="selectPaymentMethod('paypal')">
                        <div class="method-icon">
                            <i class="ri-paypal-line"></i>
                        </div>
                        <div class="method-info">
                            <h3>PayPal</h3>
                            <p>1-click checkout</p>
                        </div>
                        <div class="method-selector"></div>
                    </div>
                    
                    <div class="payment-method" data-method="crypto" onclick="selectPaymentMethod('crypto')">
                        <div class="method-icon">
                            <i class="ri-coin-line"></i>
                        </div>
                        <div class="method-info">
                            <h3>Crypto</h3>
                            <p>Bitcoin, Ethereum</p>
                        </div>
                        <div class="method-selector"></div>
                    </div>
                </div>
                
                <!-- Payment Form Area -->
                <div class="payment-form-container">
                    <!-- Card Payment Form (Default) -->
                    <div class="payment-form active" id="cardForm">
                        <div class="form-header">
                            <h3><i class="ri-bank-card-fill"></i> Card Information</h3>
                            <div class="card-brands">
                                <img src="assets/406082_card_credit_round_visa_icon.png" alt="Visa">
                                <img src="assets/1156750_finance_mastercard_payment_icon.png" alt="Mastercard">
                                <img src="assets/345580_american express_amex_billing_credit card_payment_icon.png" alt="Amex">
                                <img src="assets/4373195_card_credit_discover_logo_logos_icon.png" alt="Discover">
                            </div>
                        </div>
                        
                        <form id="cardPaymentForm">
                            <div class="form-group floating">
                                <input type="text" id="cardNumber" placeholder=" " required>
                                <label for="cardNumber">Card Number</label>
                                <i class="ri-bank-card-line"></i>
                            </div>
                            
                            <div class="form-group floating">
                                <input type="text" id="cardName" placeholder=" " required>
                                <label for="cardName">Name on Card</label>
                                <i class="ri-user-line"></i>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group floating">
                                    <input type="text" id="expiryDate" placeholder=" " required>
                                    <label for="expiryDate">Expiry Date</label>
                                    <i class="ri-calendar-line"></i>
                                </div>
                                
                                <div class="form-group floating">
                                    <input type="password" id="cvv" placeholder=" " required>
                                    <label for="cvv">CVV</label>
                                    <i class="ri-lock-line"></i>
                                    <span class="cvv-tooltip">
                                        <i class="ri-question-line"></i>
                                        <span class="tooltip-text">3-digit code on back of card</span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-footer">
                                <button type="submit" class="payment-submit">
                                    <i class="ri-lock-fill"></i> Pay $125.00
                                </button>
                                
                                <div class="security-badges">
                                    <span class="badge">
                                        <i class="ri-shield-check-line"></i> PCI Compliant
                                    </span>
                                    <span class="badge">
                                        <i class="ri-fingerprint-line"></i> 3D Secure
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Mobile Wallet Form -->
                    <div class="payment-form" id="walletForm">
                        <div class="form-header">
                            <h3><i class="ri-smartphone-line"></i> Mobile Payment</h3>
                        </div>
                        
                        <div class="wallet-options">
                            <button class="wallet-option apple-pay" onclick="handleWalletPayment('apple')">
                                <i class="ri-apple-fill"></i> Apple Pay
                            </button>
                            
                            <button class="wallet-option google-pay" onclick="handleWalletPayment('google')">
                                <i class="ri-google-fill"></i> Google Pay
                            </button>
                            
                            <button class="wallet-option samsung-pay" onclick="handleWalletPayment('samsung')">
                                <i class="ri-smartphone-line"></i> Samsung Pay
                            </button>
                        </div>
                        
                        <div class="wallet-note">
                            <i class="ri-information-line"></i>
                            <p>You'll be redirected to your wallet app to complete payment</p>
                        </div>
                    </div>
                    
                    <!-- PayPal Form -->
                    <div class="payment-form" id="paypalForm">
                        <div class="form-header">
                            <h3><i class="ri-paypal-line"></i> PayPal Checkout</h3>
                        </div>
                        
                        <div class="paypal-content">
                            <button class="paypal-button" onclick="handlePayPalPayment()">
                                <i class="ri-paypal-fill"></i> Continue with PayPal
                            </button>
                            
                            <div class="paypal-divider">
                                <span>or</span>
                            </div>
                            
                            <button class="paypal-credit-button" onclick="handlePayPalCredit()">
                                <i class="ri-money-dollar-circle-line"></i> Pay with PayPal Credit
                            </button>
                        </div>
                    </div>
                    
                    <!-- Crypto Form -->
                    <div class="payment-form" id="cryptoForm">
                        <div class="form-header">
                            <h3><i class="ri-coin-line"></i> Crypto Payment</h3>
                        </div>
                        
                        <div class="crypto-options">
                            <div class="crypto-option active" onclick="selectCryptoOption(this, 'bitcoin')">
                                <img src="assets/1175252_bitcoin_btc_cryptocurrency_icon.png" alt="Bitcoin">
                                <span>Bitcoin</span>
                            </div>
                            
                            <div class="crypto-option" onclick="selectCryptoOption(this, 'ethereum')">
                                <img src="assets/2785485_blockchain_ethereum_icon.png" alt="Ethereum">
                                <span>Ethereum</span>
                            </div>
                            
                            <div class="crypto-option" onclick="selectCryptoOption(this, 'usdc')">
                                <img src="assets/9297485_usdc_blockchain_coins_cryptocurrency_crypto_icon.png" alt="USDC">
                                <span>USDC</span>
                            </div>
                        </div>
                        
                        <div class="crypto-details">
                            <div class="crypto-qr">
                                <img src="assets/8678682_qr_code_icon.png" alt="QR Code">
                            </div>
                            
                            <div class="crypto-address">
                                <label>Payment Address</label>
                                <div class="address-field">
                                    <input type="text" id="cryptoAddress" value="1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa" readonly>
                                    <button class="copy-button" onclick="copyCryptoAddress()">
                                        <i class="ri-file-copy-line"></i>
                                    </button>
                                </div>
                                
                                <div class="crypto-amount">
                                    <span id="cryptoAmount">Amount: 0.0025 BTC</span>
                                    <span>≈ $125.00</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="crypto-note">
                            <i class="ri-time-line"></i>
                            <p>Payment will be confirmed after 3 network confirmations</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="payment-security">
                <div class="security-item">
                    <i class="ri-shield-check-fill"></i>
                    <span>256-bit Encryption</span>
                </div>
                
                <div class="security-item">
                    <i class="ri-exchange-dollar-line"></i>
                    <span>Money-Back Guarantee</span>
                </div>
                
                <div class="security-item">
                    <i class="ri-customer-service-2-line"></i>
                    <span>24/7 Support</span>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Payment Method Switching
        function selectPaymentMethod(method) {
            // Remove active class from all payment methods
            document.querySelectorAll('.payment-method').forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to selected method
            document.querySelector(`.payment-method[data-method="${method}"]`).classList.add('active');
            
            // Hide all payment forms
            document.querySelectorAll('.payment-form').forEach(form => {
                form.classList.remove('active');
            });
            
            // Show selected payment form
            document.getElementById(`${method}Form`).classList.add('active');
        }

        // Initialize with card payment as default
        document.addEventListener('DOMContentLoaded', function() {
            selectPaymentMethod('card');
            
            // Format card number input
            document.getElementById('cardNumber').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '');
                if (value.length > 0) {
                    value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
                }
                e.target.value = value;
            });
            
            // Format expiry date input
            document.getElementById('expiryDate').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;
            });
            
            // Form submission
            document.getElementById('cardPaymentForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Payment processed successfully!');
                // In a real implementation, this would process the payment
            });
        });

        // Wallet payment handlers
        function handleWalletPayment(walletType) {
            alert(`Redirecting to ${walletType} Pay...`);
            // In a real implementation, this would initiate the wallet payment
        }

        // PayPal payment handlers
        function handlePayPalPayment() {
            alert('Redirecting to PayPal for payment...');
        }

        function handlePayPalCredit() {
            alert('Redirecting to PayPal Credit...');
        }

        // Crypto payment handlers
        function selectCryptoOption(element, cryptoType) {
            // Remove active class from all options
            document.querySelectorAll('.crypto-option').forEach(option => {
                option.classList.remove('active');
            });
            
            // Add active class to selected option
            element.classList.add('active');
            
            // Update crypto details based on selection
            const addressField = document.getElementById('cryptoAddress');
            const amountField = document.getElementById('cryptoAmount');
            
            switch(cryptoType) {
                case 'bitcoin':
                    addressField.value = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
                    amountField.textContent = 'Amount: 0.0025 BTC';
                    break;
                case 'ethereum':
                    addressField.value = '0x71C7656EC7ab88b098defB751B7401B5f6d8976F';
                    amountField.textContent = 'Amount: 0.042 ETH';
                    break;
                case 'usdc':
                    addressField.value = '0xA0b86991c6218b36c1d19D4a2e9Eb0cE3606eB48';
                    amountField.textContent = 'Amount: 125 USDC';
                    break;
            }
        }

        function copyCryptoAddress() {
            const address = document.getElementById('cryptoAddress');
            address.select();
            document.execCommand('copy');
            
            // Show feedback
            const copyButton = document.querySelector('.copy-button');
            const originalHTML = copyButton.innerHTML;
            copyButton.innerHTML = '<i class="ri-check-line"></i>';
            
            setTimeout(() => {
                copyButton.innerHTML = originalHTML;
            }, 2000);
        }
    </script>
</body>
</html>