<?php
// delete_cart.php
session_start();

// Kijken of die bestaat
if (empty($_SESSION['cart']))
{
  // Nee, ga terug
  header("Location: index.php");
} else {
  // Bestaat wel, weghalen
  session_unset($_SESSION['cart']);

  header("Location: cart.php");  // Wel terug naar cart die zal zeggen dat er niets in staat... soort van bevestiging
}
?>