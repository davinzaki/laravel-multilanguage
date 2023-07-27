<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue';
import DropdownEditMenu from '../../Components/DropdownEditMenu.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Loading from '@/Components/Loading.vue';
import Button from '@/Components/Button.vue';
import number_format from "@/Composables/formatting";

const query = ref([]);
const isLoading = ref(true);
const updateAction = ref(false);
const openModalForm = ref(false);

const heads = ["Product", "Quantity", "Price", "Description", ""];

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const getData = async () => {
    axios
        .get(route('products.getdata'))
        .then((response) => {
            console.log(response.data);
            query.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
    isLoading.value = false;
};


const handleAddModalForm = () => {
    updateAction.value = false;
    openModalForm.value = true;
};

onMounted(() => {
    getData();
});


</script>

<template>
    <AppLayout title="Products">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{$t('Products')}}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto ">
                <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    <Link v-if="$page.props.auth.user" :href="route('products.index')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

                    <template v-else>
                        <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

                        <Link v-if="canRegister" :href="route('register')" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
                    </template>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <DataTable :heads="heads">
                            <tr v-if="isLoading">
                                <td
                                    class="h-[100%] overflow-hidden my-2"
                                    :colspan="heads.length"
                                >
                                    <Loading />
                                </td>
                            </tr>
                            <tr v-else-if="query.length === 0 && !isLoading">
                                <td class="overflow-hidden my-2" :colspan="heads.length">
                                    <div class="flex items-center flex-col w-full my-32">
                                        <div
                                            class="mt-9 text-slate-500 text-xl md:text-xl font-medium"
                                        >
                                            Result not found.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-for="(data, index) in query" :key="index" >
                                <td class="px-4 whitespace-nowrap h-16">
                                    {{ data.name }}
                                </td>
                                <td class="px-4 whitespace-nowrap h-16">
                                    {{ data.quantity }}
                                </td>
                                <td class="px-4 whitespace-nowrap h-16">
                                    Rp{{ number_format(data.price, 2, ",", ".") }}
                                </td>
                                <td class="px-4 whitespace-nowrap h-16">
                                    {{ data.description }}
                                </td>
                                <td class="px-4 whitespace-nowrap h-16 text-right">
                                    <DropdownEditMenu
                                        class="relative inline-flex r-0"
                                        :align="'right'"
                                        :last="index === query.length - 1 ? true : false"
                                    >
                                        <li
                                            class="cursor-pointer hover:bg-slate-100"
                                            
                                        >
                                            <div class="flex items-center space-x-2 p-3">
                                                <span>Edit</span>
                                            </div>
                                        </li>
                                        <li
                                            class="cursor-pointer hover:bg-slate-100"
                                            v-if="!isRoleTeacher"
                                        >
                                            <div
                                                class="flex justify-between items-center space-x-2 p-3"
                                            >
                                                <span>Delete</span>
                                            </div>
                                        </li>
                                    </DropdownEditMenu>
                                </td>
                            </tr>
                        </DataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>