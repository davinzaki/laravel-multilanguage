<script setup>
import { array, bool, string } from 'vue-types';
const props = defineProps({
    heads: array().isRequired,
    isLoading: bool().def(false),
    freezeTable: bool().def(false),
    wrapperClass: string()
})
</script>

<template>
    <div class="overflow-y-visible ">
        <!-- Table -->
        <div class="overflow-x-auto px-3 no-scrollbar" 
            :class="[{ 'min-h-[40vh] sm:min-h-[50vh]': isLoading }, { 'freeze-table': freezeTable }], wrapperClass">
            <table class="table-auto w-full relative" :class="[{ 'min-h-[40vh] sm:min-h-[50vh]': isLoading }, { 'border-separate border-spacing-0': freezeTable }]">
                <!-- Table header -->
                <thead
                    class="text-base  font-semibold capitalize text-slate-500 bg-slate-50" :class="{'header': freezeTable}">
                    <tr>
                        <th v-for="(head, index) in heads" :key="index"
                            class="px-4 h-12 whitespace-nowrap border-t border-b border-slate-200" :class="{'fixed-header': freezeTable && index === 0}">
                            <div class="font-semibold text-left" :class="{'!text-center': freezeTable && index > 0}">

                                {{ $t(head) }}
                            </div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody
                    class="text-sm text-slate-600 font-normal min-h-[40%] divide-y divide-slate-200 border-b border-slate-200">
                    <slot></slot>
                </tbody>
            </table>
        </div>
    </div>
</template>