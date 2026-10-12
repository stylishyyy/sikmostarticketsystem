<!DOCTYPE html>
<html>
<head>
    <title>Obavijest iz IT Sustava</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 20px;">
    <div style="max-w-600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; border-top: 4px solid #4f46e5;">
        <h2 style="color: #1f2937; margin-bottom: 5px;">Ažuriranje Tiketa #<?php echo e($ticket->id); ?></h2>
        <p style="color: #4b5563; font-size: 16px; font-weight: bold; padding: 10px; background-color: #e0e7ff; border-radius: 5px;">
            <?php echo e($messageBody); ?>

        </p>
        
        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 20px 0;">
        
        <p><strong>Naslov kvara:</strong> <?php echo e($ticket->title); ?></p>
        <p><strong>Kategorija:</strong> <?php echo e($ticket->category->name ?? 'Ostalo'); ?></p>
        <p><strong>Prioritet:</strong> <span style="text-transform: uppercase;"><?php echo e($ticket->priority); ?></span></p>
        <p><strong>Trenutni status:</strong> <span style="text-transform: uppercase;"><?php echo e($ticket->status); ?></span></p>
        
        <p style="margin-top: 30px; font-size: 12px; color: #9ca3af;">
            Ovo je automatska poruka. Prijavite se u sustav za više detalja i pregled privitaka.
        </p>
    </div>
</body>
</html><?php /**PATH C:\inetpub\wwwroot\Sites\helpdesk\resources\views/emails/ticket_notification.blade.php ENDPATH**/ ?>