<script setup xmlns="http://www.w3.org/1999/html">
import {Head} from "@inertiajs/vue3";
import _ from "lodash";

// component
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UploadForm from "@/Pages/Books/Partials/UploadForm.vue";
import List from "@/Pages/Books/Partials/List.vue";

defineProps(['books']);
</script>

<template>
    <Head title="Books 電子帳簿一覧"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿</h2>
        </template>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y p-4">
            <UploadForm/>
            <List v-if="!_.isEmpty(books)"/>
            <div v-else class="books-empty border-top-0"> ファイルを登録してください。</div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: "Index.vue"
}
</script>
