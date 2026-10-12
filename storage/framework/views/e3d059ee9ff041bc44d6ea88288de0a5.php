<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200 relative">
    
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800">IT Nadzorna ploča</h2>
        <p class="text-sm text-gray-500 mt-1">Centralni pregled prijavljenih kvarova, zaduženja i SLA rokova.</p>
    </div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('note_message')): ?>
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
            <?php echo e(session('note_message')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- FILTERI U JEDNOM REDU -->
    <div class="flex flex-wrap items-center gap-4 mb-6 p-4 rounded-lg" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
        <div class="flex-grow md:w-1/3">
            <input type="text" wire:model.live="search" placeholder="Pretraži tikete po naslovu..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        </div>
        
        <div class="w-full md:w-auto">
            <select wire:model.live="statusFilter" class="w-full md:w-48 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">Svi statusi</option>
                <option value="novo">Novo</option>
                <option value="u_obradi">U obradi</option>
                <option value="rijeseno">Riješeno</option>
            </select>
        </div>

        <div class="w-full md:w-auto">
            <select wire:model.live="categoryFilter" class="w-full md:w-48 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">Sve kategorije</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
    </div>    
    
    <!-- GLAVNA TABLICA -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full text-left text-sm text-gray-600">
            <thead class="text-xs uppercase tracking-wider text-gray-500" style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th class="p-4 font-bold">ID</th>
                    <th class="p-4 font-bold">Kvar i Opis</th>
                    <th class="p-4 font-bold">Prijavio</th>
                    <th class="p-4 font-bold">Stroj / Oprema</th>
                    <th class="p-4 font-bold text-center">Prioritet</th>
                    <th class="p-4 font-bold">SLA Rok</th>
                    <th class="p-4 font-bold">Zaduženje / Status</th>
                    <th class="p-4 font-bold text-center">Akcije</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php 
                    $pri = strtolower(trim($ticket->priority)); 
                    $isOverdue = $ticket->isOverdue();
                    
                    if (str_contains($pri, 'kritic') || str_contains($pri, 'critical')) {
                        $badgeStyle = 'background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;';
                        $badgeText = 'Kritičan';
                    } elseif (str_contains($pri, 'visok') || str_contains($pri, 'high')) {
                        $badgeStyle = 'background-color: #ffedd5; color: #9a3412; border: 1px solid #fdba74;';
                        $badgeText = 'Visok';
                    } elseif (str_contains($pri, 'srednj') || str_contains($pri, 'medium')) {
                        $badgeStyle = 'background-color: #dcfce7; color: #166534; border: 1px solid #86efac;';
                        $badgeText = 'Srednji';
                    } else {
                        $badgeStyle = 'background-color: #dbeafe; color: #1e40af; border: 1px solid #93c5fd;';
                        $badgeText = 'Nizak';
                    }

                    $rowStyle = $isOverdue ? 'background-color: #fff5f5; border-left: 4px solid #ef4444;' : 'border-left: 4px solid transparent;';
                ?>
                
                <tr class="hover:bg-gray-50 transition-colors" style="<?php echo e($rowStyle); ?>">
                    <td class="p-4 font-black" style="color: #4f46e5;">
                        #<?php echo e(str_pad($ticket->id, 4, '0', STR_PAD_LEFT)); ?>

                    </td>
                    
                    <td class="p-4">
                        <div class="font-bold text-gray-900 flex items-center gap-2">
                            <?php echo e($ticket->title); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOverdue): ?>
                                <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded shadow-sm animate-pulse" style="background-color: #ef4444; color: white;">
                                    Eskalacija
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 truncate max-w-xs"><?php echo e($ticket->description); ?></div>
                    </td>
                    
                    <td class="p-4 font-medium text-gray-700"><?php echo e($ticket->user->name ?? 'Sustav'); ?></td>
                    
                    <td class="p-4">
                        <div class="font-bold text-gray-800"><?php echo e($ticket->category->name ?? 'Ostalo'); ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket->asset_id): ?>
                            <div class="text-[11px] font-bold mt-1 px-2 py-0.5 rounded inline-block" style="background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe;">
                                Ref: <?php echo e($ticket->asset->name ?? 'Nepoznato'); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 text-[11px] font-bold rounded-full shadow-sm" style="<?php echo e($badgeStyle); ?>">
                            <?php echo e($badgeText); ?>

                        </span>
                    </td>

                    <td class="p-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket->due_at): ?>
                            <div class="text-xs font-bold <?php echo e($isOverdue ? 'text-red-700' : 'text-gray-700'); ?>">
                                <?php echo e($ticket->due_at->format('d.m.Y H:i')); ?>

                            </div>
                            <div class="text-[10px] <?php echo e($isOverdue ? 'text-red-500 font-bold' : 'text-gray-500'); ?>">
                                <?php echo e($ticket->due_at->diffForHumans()); ?>

                            </div>
                        <?php else: ?>
                            <span class="text-xs text-gray-400">-</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    <td class="p-4">
                        <select wire:change="assignTicket(<?php echo e($ticket->id); ?>, $event.target.value)" class="text-xs rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 mb-2 w-full">
                            <option value="">- Nije zaduženo -</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($worker->id); ?>" <?php echo e($ticket->assigned_to == $worker->id ? 'selected' : ''); ?>>
                                    <?php echo e($worker->name); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <select wire:change="updateStatus(<?php echo e($ticket->id); ?>, $event.target.value)" class="text-xs rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 w-full" style="background-color: #f8fafc;">
                            <option value="novo" <?php echo e($ticket->status == 'novo' ? 'selected' : ''); ?>>Novo</option>
                            <option value="u_obradi" <?php echo e($ticket->status == 'u_obradi' ? 'selected' : ''); ?>>U obradi</option>
                            <option value="rijeseno" <?php echo e($ticket->status == 'rijeseno' ? 'selected' : ''); ?>>Riješeno</option>
                        </select>
                    </td>
                    
                    <td class="p-4 text-center">
                        <div class="flex flex-col gap-2">
                            <button wire:click="openModal(<?php echo e($ticket->id); ?>)" class="flex items-center justify-center gap-1 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm transition-colors" style="background-color: #1e293b;">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                Detalji
                            </button>
                            <button wire:click="deleteTicket(<?php echo e($ticket->id); ?>)" wire:confirm="Jeste li sigurni da želite trajno obrisati ovaj tiket?" class="flex items-center justify-center gap-1 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm transition-colors" style="background-color: #dc2626;">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                Obriši
                            </button>
                        </div>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <?php echo e($tickets->links()); ?>

    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isModalOpen): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-60"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4 border-b pb-2">
                        Detalji i bilješke (ID: #<?php echo e(str_pad($selectedTicketId, 4, '0', STR_PAD_LEFT)); ?>)
                    </h3>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attachment_path): ?>
                        <?php
                            $attachments = json_decode($attachment_path, true);
                            if (!is_array($attachments)) {
                                $attachments = [$attachment_path];
                            }
                        ?>
                        <div class="mb-4 rounded p-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                            <span class="block text-[11px] font-bold text-gray-500 mb-2 uppercase">Priložene datoteke</span>
                            <div class="flex flex-wrap gap-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <a href="<?php echo e(asset('storage/' . $file)); ?>" target="_blank" class="inline-block">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Illuminate\Support\Str::endsWith(strtolower($file), ['.jpg', '.jpeg', '.png'])): ?>
                                            <img src="<?php echo e(asset('storage/' . $file)); ?>" class="h-16 w-16 object-cover rounded border border-gray-300 hover:opacity-80">
                                        <?php else: ?>
                                            <span class="font-bold text-indigo-600 hover:bg-gray-200 bg-white p-2 border rounded shadow-sm text-xs flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                                Prilog <?php echo e($index + 1); ?>

                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </a>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Interni komentar / Odgovor radniku</label>
                        <textarea wire:model="admin_notes" rows="5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3"></textarea>
                    </div>
                </div>
                <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button wire:click="saveNotes" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-sm font-bold text-white sm:ml-3 sm:w-auto" style="background-color: #4f46e5;">
                        Spremi promjene
                    </button>
                    <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto">
                        Odustani
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\inetpub\wwwroot\Sites\helpdesk\resources\views/livewire/ticket-list.blade.php ENDPATH**/ ?>