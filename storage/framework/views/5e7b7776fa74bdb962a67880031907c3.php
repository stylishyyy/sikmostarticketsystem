<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200 relative mb-8">
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-xl font-bold text-gray-800">Statistika i Analitika</h2>
        <p class="text-sm text-gray-500 mt-1">Ključni pokazatelji performansi (KPI) sustava za održavanje.</p>
    </div>

    <!-- 4 GLAVNE KARTICE -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="p-4 rounded-lg shadow-sm" style="background-color: #f8fafc; border: 1px solid #cbd5e1;">
            <div class="text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1">Ukupno prijava</div>
            <div class="text-3xl font-black" style="color: #334155;"><?php echo e($totalTickets); ?></div>
        </div>
        
        <div class="p-4 rounded-lg shadow-sm" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
            <div class="text-[11px] font-black text-green-600 uppercase tracking-wider mb-1">Riješeno</div>
            <div class="text-3xl font-black" style="color: #166534;"><?php echo e($resolvedTickets); ?></div>
        </div>
        
        <div class="p-4 rounded-lg shadow-sm" style="background-color: #fffbeb; border: 1px solid #fde68a;">
            <div class="text-[11px] font-black text-yellow-600 uppercase tracking-wider mb-1">U obradi / Novo</div>
            <div class="text-3xl font-black" style="color: #92400e;"><?php echo e($openTickets); ?></div>
        </div>
        
        <div class="p-4 rounded-lg shadow-sm" style="background-color: #fef2f2; border: 1px solid #fecaca;">
            <div class="text-[11px] font-black text-red-600 uppercase tracking-wider mb-1">Kritični prioriteti</div>
            <div class="text-3xl font-black" style="color: #991b1b;"><?php echo e($criticalTickets); ?></div>
        </div>
    </div>

    <!-- TOP LISTE -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Top Radnici -->
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center gap-2" style="background-color: #f8fafc;">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Top 5 IT Radnika (Riješeno)</h3>
            </div>
            <ul class="divide-y divide-gray-100 bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topWorkers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workerData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li class="flex justify-between items-center p-3 hover:bg-gray-50 transition-colors">
                        <span class="font-bold text-sm text-gray-800"><?php echo e($workerData->assignedWorker->name ?? 'Nepoznato'); ?></span>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded shadow-sm" style="background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe;">
                            <?php echo e($workerData->total); ?> radova
                        </span>
                    </li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <li class="p-4 text-gray-500 text-xs text-center">Nema dovoljno podataka.</li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>

        <!-- Najkvarljivija oprema -->
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center gap-2" style="background-color: #f8fafc;">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.83-5.83M15.46 5.46l-1.04-1.04a2.25 2.25 0 00-3.182 0l-1.04 1.04m-6.364 0l-1.04 1.04a2.25 2.25 0 000 3.182l1.04 1.04m6.364 0l1.04-1.04a2.25 2.25 0 000-3.182l-1.04-1.04" /></svg>
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Oprema s najviše kvarova</h3>
            </div>
            <ul class="divide-y divide-gray-100 bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topAssets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assetData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li class="flex justify-between items-center p-3 hover:bg-gray-50 transition-colors">
                        <span class="font-bold text-sm text-gray-800"><?php echo e($assetData->asset->name ?? 'Nepoznato'); ?></span>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded shadow-sm" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;">
                            <?php echo e($assetData->total); ?> kvarova
                        </span>
                    </li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <li class="p-4 text-gray-500 text-xs text-center">Nema evidentiranih kvarova na strojevima.</li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>

    </div>
</div><?php /**PATH C:\inetpub\wwwroot\Sites\helpdesk\resources\views/livewire/ticket-statistics.blade.php ENDPATH**/ ?>