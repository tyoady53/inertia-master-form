<template>
    <Head> Tickets - Master Form </Head>
</template>
<main class="c-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded-3 shadow-border-top-purple">
                    <div class="card-header">
                        <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> Tickethe</span>
                    </div>
                </div>
            </div>
        </div>
</main>
<script>
    import LayoutApp from '../../../Layouts/App.vue';

    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        layout: LayoutApp,

        components: {
            Head, Link
        },
    }
</script>

<style>

</style>