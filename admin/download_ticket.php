RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# php -- BEGIN cPanel-generated handler, do not edit
# Set the “ea-php81” package as the default “PHP” programming language.
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php81 .php .php8 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit


<?php
require_once('..//admin/fpdf/fpdf.php'); // Include the FPDF library

// Function to generate ticket content
function generate_ticket($studentName, $current_date) {
    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();
    
   
    $pdf->SetFont('Arial','B',18);
    // Set color for school name
    $pdf->Image("../images/back.jpg", $pdf->GetPageWidth()/2 - 15, 3, 30, 0, 'JPG'); //

    $pdf->SetTextColor(0, 0, 255); // Blue color

    // Add school name to the ticket
    $pdf->Cell(0, 10, 'Pace Driving School', 0, 1, 'C'); // Center-aligned
    $pdf->SetTextColor(0); // Black color

    // Set font for other fields
    $pdf->SetFont('Arial', '', 16);
    $pdf->Cell(0, 10, 'Ticket Information', 0, 1);

    $pdf->SetFont('Arial', '', 12);

    // Add student name to the ticket
    $pdf->Cell(0, 10, 'Student Name: ' . $studentName, 0, 1);

    // Add current download date to the ticket
    $pdf->Cell(0, 10, 'Download Date: ' . $current_date, 0, 1);

    // Add message to the ticket
    $pdf->Cell(0, 10, 'Message: Proceed to Learning ', 0, 1);

    // Add logo to the ticket
   
    
    // Output PDF as a string
    ob_start();
    $pdf->Output('D', 'ticket.pdf'); // 'D' parameter forces download
    ob_end_flush();
}

// Check if necessary data is provided in the URL
if (isset($_GET['id_no']) && isset($_GET['sname'])) {
    $studentName = $_GET['sname'];
    $currentDate = date('Y-m-d');
 
    // Generate ticket for the logged-in student
    generate_ticket($studentName, $currentDate);
} 
else {
    // User data is not provided in the URL, redirect or display an error message
    echo "User data is missing. Please try again.";
}
?>
