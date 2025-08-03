
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Performance Report</title>
    <link rel="stylesheet" href="../Styles/seller_report.css">
</head>
<body>
    <div class="container">
        <h1>Seller Performance Report</h1>
        <div id="report">
            <h2>Total Sales: <span id="total-sales"></span></h2>
            <h2>Number of Orders: <span id="number-of-orders"></span></h2>
            <h2>Average Order Value (AOV): <span id="average-order-value"></span></h2>
            <h2>Customer Feedback:</h2>
            <div id="customer-feedback"></div>
        </div>
    </div>
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const data = {
                customer_feedback: {
                average_rating: 4.5,
                total_reviews: 20,
                positive_comments: [
                    "Great service!",
                    "Fast delivery!",
                    "Excellent product quality!",
                    "Seller was very responsive to my queries.",
                    "Product was exactly as described."
                ],
                negative_comments: [
                    "Product was damaged on arrival.",
                    "Customer service was unresponsive.",
                    "Delivery took longer than expected.",
                    "Product did not match the description.",
                    "Packaging could be improved."
                ]
            }
        }
            fetch('seller_report_data.php') // Fetch from the data file
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-sales').innerText = `₹${data.total_sales.toLocaleString()}`;
                    document.getElementById('number-of-orders').innerText = data.number_of_orders;
                    document.getElementById('average-order-value').innerText = `₹${data.average_order_value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    
                    const feedbackDiv = document.getElementById('customer-feedback');
        feedbackDiv.innerHTML = `<strong>Average Rating:</strong> ${data.customer_feedback.average_rating} (${data.customer_feedback.total_reviews} reviews)<br>
                                 <strong>Positive Comments:</strong> ${data.customer_feedback.positive_comments.join(', ')}<br>
                                 <strong>Negative Comments:</strong> ${data.customer_feedback.negative_comments.join(', ')}`;
                })
                .catch(error => console.error('Error fetching report:', error));
        });

    </script>
</body>
</html>