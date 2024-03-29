<template>
  <PageComponentVue title="Главная">
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Информация об опросах
        </h1>
      </div>
    </template>

    <template v-slot:main>
      <div class="flex justify-center" v-if="loading">Загрузка...</div>

      <div v-else>
        <div
          class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 text-gray-700"
        >
          <div
            class="bg-white shadow-md p-3 text-center flex flex-col order-1 md:order-2 animate-fade-in-down"
            style="animation-delay: 0.1s"
          >
            <h3 class="text-2xl font-semibold">Всего опросов</h3>
            <div
              class="text-8xl font-semibold flex flex-1 items-center justify-center"
            >
              {{ data.totalSurveys }}
            </div>
          </div>

          <div
            class="bg-white shadow-md p-3 text-center flex flex-col order-2 md:order-4 animate-fade-in-down"
            style="animation-delay: 0.2s"
          >
            <h3 class="text-2xl font-semibold">Пройденные опросы</h3>
            <div
              class="text-8xl font-semibold flex flex-1 items-center justify-center"
            >
              {{ data.totalAnswers }}
            </div>
          </div>

          <div
            class="bg-white shadow-md p-4 row-span-2 order-3 md:order-1 animate-fade-in-down"
          >
            <h3 class="text-2xl font-semibold">Последний опрос</h3>
            <img
              :src="data.latestSurvey.image_url"
              :alt="data.latestSurvey.slug"
              class="w-[240px] mx-auto"
            />
            <h3 class="font-bold text-xl mb-3">
              {{ data.latestSurvey.title }}
            </h3>
            <div class="flex justify-between text-sm mb-1">
              <div>Дата создания:</div>
              <div>{{ data.latestSurvey.created_at }}</div>
            </div>

            <div class="flex justify-between text-sm mb-1">
              <div>Дата истечения опроса:</div>
              <div>{{ data.latestSurvey.expire_date }}</div>
            </div>

            <div class="flex justify-between text-sm mb-1">
              <div>Статус:</div>
              <div>
                {{ data.latestSurvey.status ? "Активный" : "Завершённый" }}
              </div>
            </div>

            <div class="flex justify-between text-sm mb-1">
              <div>Вопросов в опросе:</div>
              <div>{{ data.latestSurvey.questions }}</div>
            </div>

            <div class="flex justify-between text-sm mb-3">
              <div>Ответов:</div>
              <div>{{ data.latestSurvey.answers }}</div>
            </div>

            <div class="flex justify-between">
              <router-link
                :to="{
                  name: 'SurveyView',
                  params: { id: data.latestSurvey.id },
                }"
                class="flex py-2 px-4 border border-transparent text-sm rounded-md text-sky-600 hover:bg-sky-800 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-sky-600"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-2"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                  />
                </svg>
                Редактировать опрос
              </router-link>

              <button
                class="flex py-2 px-4 border border-transparent text-sm rounded-md text-sky-600 hover:bg-sky-800 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-sky-600"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-2"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                  <path
                    fill-rule="evenodd"
                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                    clip-rule="evenodd"
                  />
                </svg>
                Ответы
              </button>
            </div>
          </div>

          <div
            class="bg-white shadow-md p-3 row-span-2 order-4 md:order-3 animate-fade-in-down"
            style="animation-delay: 0.3s"
          >
            <div class="flex justify-between items-center mb-3 px-2">
              <h3 class="text-2xl font-semibold">Последние ответы</h3>
              <a
                href="javascript:void(0)"
                class="text-sm text-blue-500 hover:decoration-blue-500"
              >
                Посмотреть всё
              </a>
            </div>

            <div v-if="data.latestAnswers.length">
              <a
                href="#"
                v-for="answer of data.latestAnswers"
                :key="answer.id"
                class="block p-2 hover:bg-gray-100/90"
              >
                <div class="font-semibold">{{ answer.survey.title }}</div>
                <small>
                  Отвечено в:
                  <i class="font-semibold">{{ answer.end_date }}</i>
                </small>
              </a>
            </div>
            <div v-else class="text-gray-600 text-center py-16">
              У вас пока нет ответов
            </div>
          </div>
        </div>
      </div>
    </template>
  </PageComponentVue>
</template>

<script setup>
import PageComponentVue from "../components/PageComponent.vue";
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const loading = computed(() => store.state.dashboard.loading);
const data = computed(() => store.state.dashboard.data);

store.dispatch("getDashboardData");
</script>
