@props(['transaction','interval'])
<div class="container">
    <h2 class="pb-2 border-bottom">Reports</h2>
    <div class="container pb-3">
        <x-admin-dashboard.reports.transactions :transaction="$transaction" :interval="$interval"/>
    </div>
</div>