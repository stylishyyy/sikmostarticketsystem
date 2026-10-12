<div class="max-w-7xl mx-auto space-y-8 mb-8">
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('assigned_message')): ?>
        <div class="p-4 text-sm font-bold rounded-lg shadow-sm" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
            <?php echo e(session('assigned_message')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- SEKCIJA 1: ZADACI DODIJELJENI MENI (Ono što radnik mora riješiti) -->
    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Zadaci dodijeljeni meni</h2>
            <p class="text-sm text-gray-500 mt-1">Kvarovi i zahtjevi koje ste vi zaduženi riješiti.</p>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="text-left text-sm text-gray-600" style="width: 100%;">
                <thead class="text-xs uppercase tracking-wider text-gray-600" style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="p-4 font-bold" style="width: 10%;">ID</th>
                        <th class="p-4 font-bold" style="width: 35%;">Detalji kvara</th>
                        <th class="p-4 font-bold" style="width: 20%;">Prijavio</th>
                        <th class="p-4 font-bold" style="width: 15%;">Rok (SLA)</th>
                        <th class="p-4 font-bold" style="width: 20%;">Ažuriraj status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $assignedToMe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $isOverdue = $ticket->isOverdue();
                        $rowStyle = $isOverdue ? 'background-color: #fff5f5; border-left: 4px solid #ef4444;' : 'border-left: 4px solid transparent;';
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors" style="<?php echo e($rowStyle); ?>">
                        <td class="p-4 font-black" style="color: #4f46e5;">#<?php echo e(str_pad($ticket->id, 4, '0', STR_PAD_LEFT)); ?></td>
                        <td class="p-4">
                            <div class="font-bold text-gray-900"><?php echo e($ticket->title); ?></div>
                            <div class="text-xs text-gray-500 mt-1"><?php echo e(\Illuminate\Support\Str::limit($ticket->description, 60)); ?></div>
                            <div class="text-[11px] font-bold mt-1 px-2 py-0.5 rounded inline-block" style="background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                                <?php echo e($ticket->category->name ?? 'Ostalo'); ?>

                            </div>
                        </td>
                        <td class="p-4 font-medium text-gray-700">
                            <?php echo e($ticket->user->name ?? 'Nepoznato'); ?>

                        </td>
                        <td class="p-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket->due_at): ?>
                                <div class="text-xs font-bold <?php echo e($isOverdue ? 'text-red-700' : 'text-gray-700'); ?>">
                                    <?php echo e($ticket->due_at->format('d.m.Y H:i')); ?>

                                </div>
                                <div class="text-[10px] <?php echo e($isOverdue ? 'text-red-500 font-bold uppercase' : 'text-gray-500'); ?>">
                                    <?php echo e($ticket->due_at->diffForHumans()); ?>

                                </div>
                            <?php else: ?>
                                <span class="text-xs text-gray-400">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="p-4">
                            <!-- Padajući izbornik koji poziva updateStatus funkciju -->
                            <select wire:change="updateStatus(<?php echo e($ticket->id); ?>, $event.target.value)" class="w-full text-xs rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold" style="background-color: #f8fafc; color: #0f172a;">
                                <option value="novo" <?php echo e($ticket->status == 'novo' ? 'selected' : ''); ?>>Novo</option>
                                <option value="u_obradi" <?php echo e($ticket->status == 'u_obradi' || $ticket->status == 'u obradi' ? 'selected' : ''); ?>>U obradi</option>
                                <option value="rijeseno" <?php echo e($ticket->status == 'rijeseno' ? 'selected' : ''); ?>>Riješeno</option>
                            </select>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500 font-medium">Trenutno nemate dodijeljenih zadataka.</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SEKCIJA 2: MOJI PRIJAVLJENI KVAROVI (Ono što je radnik prijavio) -->
    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Moji prijavljeni kvarovi</h2>
            <p class="text-sm text-gray-500 mt-1">Status kvarova i zahtjeva koje ste vi otvorili.</p>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="text-left text-sm text-gray-600" style="width: 100%;">
                <thead class="text-xs uppercase tracking-wider text-gray-600" style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="p-4 font-bold" style="width: 10%;">ID</th>
                        <th class="p-4 font-bold" style="width: 35%;">Opis kvara</th>
                        <th class="p-4 font-bold" style="width: 20%;">Datum prijave</th>
                        <th class="p-4 font-bold" style="width: 15%;">Status</th>
                        <th class="p-4 font-bold" style="width: 20%;">Zaduženi radnik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $mySubmittedTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $status = strtolower(trim($ticket->status));
                        if ($status === 'novo') {
                            $statusStyle = 'background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe;';
                            $statusText = 'NOVO';
                        } elseif ($status === 'u_obradi' || $status === 'u obradi') {
                            $statusStyle = 'background-color: #fef08a; color: #854d0e; border: 1px solid #fde047;';
                            $statusText = 'U OBRADI';
                        } else {
                            $statusStyle = 'background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0;';
                            $statusText = 'RIJEŠENO';
                        }
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-black" style="color: #64748b;">#<?php echo e(str_pad($ticket->id, 4, '0', STR_PAD_LEFT)); ?></td>
                        <td class="p-4">
                            <div class="font-bold text-gray-900"><?php echo e($ticket->title); ?></div>
                            <div class="text-xs text-gray-500 mt-1"><?php echo e(\Illuminate\Support\Str::limit($ticket->description, 50)); ?></div>
                        </td>
                        <td class="p-4 font-medium text-gray-600">
                            <?php echo e($ticket->created_at->format('d.m.Y H:i')); ?>

                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-[10px] font-black rounded shadow-sm" style="<?php echo e($statusStyle); ?>">
                                <?php echo e($statusText); ?>

                            </span>
                        </td>
                        <td class="p-4 font-bold text-gray-800">
                            <?php echo e($ticket->assignedWorker->name ?? 'Na čekanju'); ?>

                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500 font-medium">Trenutno nemate prijavljenih kvarova.</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH C:\inetpub\wwwroot\Sites\helpdesk\resources\views/livewire/my-tickets.blade.php ENDPATH**/ ?>