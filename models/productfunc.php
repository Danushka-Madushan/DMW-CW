<?php
function reduceStock($product_id, $reduce_amount, $pdo) {
    // Check if reduce_amount is positive
    if ($reduce_amount <= 0) {
        echo "Error: The amount to reduce must be positive.";
        return 5;
    }

    // Prepare query to fetch the current stock for the product
    $stmt = $pdo->prepare("SELECT stock FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the current stock
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If product not found, show an error
    if (!$product) {
        echo "Error: Product not found.";
        return 3;
    }

    $current_stock = $product['stock'];

    // Check if the provided amount to reduce is less than or equal to the available stock
    if ($reduce_amount > $current_stock) {
        echo "Error: Not enough stock available.";
        return 2;
    }

    // Reduce the stock by the provided amount
    $new_stock = $current_stock - $reduce_amount;

    // Prepare update query
    $update_stmt = $pdo->prepare("UPDATE products SET stock = :new_stock WHERE product_id = :product_id");
    $update_stmt->bindParam(':new_stock', $new_stock, PDO::PARAM_INT);
    $update_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    
    // Execute the update query
    if ($update_stmt->execute()) {
        echo "Stock updated successfully.";
        return 1;
    } else {
        echo "Error: Could not update stock.";
        return 4;
    }
}

function getAvailableStock($product_id, $pdo) {
    // Prepare query to fetch the current stock for the product
    $stmt = $pdo->prepare("SELECT stock FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the current stock
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If product not found, return error message
    if (!$product) {
        echo "Error: Product not found.";
        return false;
    }
    
    // Return the available stock
    return $product['stock'];
}

?>
