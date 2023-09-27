<template>
  <PageComponentVue>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Опросы</h1>

        <router-link
          :to="{ name: 'SurveyCreate' }"
          class="py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-600"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-4 h-4 -mt-1 inline-block"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 4.5v15m7.5-7.5h-15"
            />
          </svg>

          Добавить новый опрос
        </router-link>
      </div>
    </template>

    <template v-slot:main>
      <div class="flex justify-center" v-if="surveys.loading">Загрузка...</div>

      <div v-else>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
          <SurveyListItemVue
            class="opacity-0 animate-fade-in-down"
            v-for="(survey, index) in surveys.data"
            :key="survey.id"
            :survey="survey"
            :style="{ animationDelay: `${index * 0.1}s` }"
            @delete="deleteSurvey(survey)"
          />
        </div>

        <div class="flex justify-center mt-5">
          <nav
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
            aria-label="Pagination"
          >
            <a
              v-for="(link, i) of surveys.links"
              :key="i"
              :disabled="!link.url"
              @click="getForPage($event, link)"
              aria-current="page"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
              :class="[
                link.active
                  ? 'z-10 bg-indigo-50 border-sky-700 text-sky-800'
                  : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50 cursor-pointer',
                i === 0 ? 'rounded-l-md bg-gray-100 text-gray-700' : '',
                i === surveys.links.length - 1 ? 'rounded-r-md' : '',
              ]"
              v-html="link.label"
            >
            </a>
          </nav>
        </div>
      </div>
    </template>
  </PageComponentVue>
</template>

<script>
import PageComponentVue from "../components/PageComponent.vue";
import SurveyListItemVue from "../components/SurveyListItem.vue";
import { computed } from "vue";

export default {
  name: "Surveys",
  components: {
    PageComponentVue,
    SurveyListItemVue,
  },
  data: () => ({
    surveys: {},
  }),
  mounted() {
    this.surveys = computed(() => this.$store.state.surveys);

    this.$store.dispatch("getSurveys");
  },
  methods: {
    deleteSurvey(survey) {
      if (confirm(`Вы уверены, что хотите удалить этот опрос?`)) {
        this.$store.dispatch("deleteSurvey", survey.id).then(() => {
          this.$store.dispatch("getSurveys");
        });
      }
    },

    getForPage(event, link) {
      event.preventDefault();

      if (!link.url || link.active) {
        return;
      }

      this.$store.dispatch("getSurveys", { url: link.url });
    },
  },
};
</script>
