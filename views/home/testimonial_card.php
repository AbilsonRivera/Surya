<!-- testimonial_card.php -->
<div class="testimonial-card">
  <p class="testimonial-text">
    <?php echo $t['testimonial_text']; ?>
  </p>
  <div class="d-flex align-items-center mt-2">
    <img src="<?php echo $t['avatar_path']; ?>" class="testimonial-avatar" alt="Avatar">
    <div class="ms-3">
      <h6 class="mb-0"><?php echo $t['customer_name']; ?></h6>
      <div class="rating-stars">
        <!-- Imprime estrellas según rating -->
        <?php for($r=1; $r<=$t['rating']; $r++): ?>
          ★
        <?php endfor; ?>
      </div>
    </div>
  </div>
</div>
