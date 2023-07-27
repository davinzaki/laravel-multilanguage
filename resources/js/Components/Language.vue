<script setup>
import axios from "axios"
// import { notify } from "notiwind"
import { string } from 'vue-types';
import { ref, onMounted, onUnmounted } from 'vue';
import { loadLanguageAsync, getActiveLanguage } from 'laravel-vue-i18n';

const dropdownOpen = ref(false)
const trigger = ref(null)
const dropdown = ref(null)
const locale = ref(null)
const props = defineProps({
    align: string()
})

// close on click outside
const clickHandler = ({ target }) => {
    if (!dropdownOpen.value || dropdown.value.contains(target) || trigger.value.contains(target)) return
    dropdownOpen.value = false
}

// close if the esc key is pressed
const keyHandler = ({ keyCode }) => {
    if (!dropdownOpen.value || keyCode !== 27) return
    dropdownOpen.value = false
}

const setLocale = async (lang) => {
    loadLanguageAsync(lang)
    axios.post(route('localization.switch', {'language': lang}))
    locale.value = lang
    dropdownOpen.value = !dropdownOpen.value
}

onMounted(() => {
    document.addEventListener('click', clickHandler)
    document.addEventListener('keydown', keyHandler)
    locale.value = getActiveLanguage()
})

onUnmounted(() => {
    document.removeEventListener('click', clickHandler)
    document.removeEventListener('keydown', keyHandler)
})
</script>

<template>
    <div class="relative inline-flex">
        <button ref="trigger" class="inline-flex justify-center items-center group -mt-2" aria-haspopup="true"
            @click.prevent="dropdownOpen = !dropdownOpen" :aria-expanded="dropdownOpen">
            <country-flag country='id' size='normal' v-if="locale === 'id'"/>
            <country-flag country='us' size='normal' v-if="locale === 'en'"/>
        </button>
        <transition enter-active-class="transition ease-out duration-200 transform"
            enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-out duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="dropdownOpen"
                class="origin-top-right z-10 absolute top-full min-w-36 bg-white border border-slate-200 rounded shadow-lg overflow-hidden mt-2"
                :class="align === 'right' ? 'right-0' : 'left-0'">
                <ul ref="dropdown" @focusin="dropdownOpen = true" @focusout="dropdownOpen = false">
                    <li>
                        <a class="font-medium text-sm hover:text-white hover:bg-slate-800 flex items-center py-1 px-3 cursor-pointer" @click.prevent="setLocale('en')" :class="{
                            'text-white bg-slate-800': locale === 'en',
                            'text-slate-800': locale !== 'en'
                        }">
                            <country-flag country='us' size='small' class="mr-3"/> English
                        </a>
                    </li>
                    <li>
                        <a class="font-medium text-sm hover:text-white hover:bg-slate-800 flex items-center py-1 px-3 cursor-pointer" @click.prevent="setLocale('id')" :class="{
                            'text-white bg-slate-800': locale === 'id',
                            'text-slate-800': locale !== 'id'
                        }">
                            <country-flag country='id' size='small' class="mr-3"/> Indonesia
                        </a>
                    </li>
                </ul>
            </div>
        </transition>
    </div>
</template>
