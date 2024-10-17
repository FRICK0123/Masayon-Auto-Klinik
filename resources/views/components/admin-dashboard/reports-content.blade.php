@props(['transaction','interval'])
<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
        <h5 class="pt-2">REPORTS</h5>
    </div>
    <div class="container pb-3">
        <x-admin-dashboard.reports.transactions :transaction="$transaction" :interval="$interval"/>
    </div>
</div>