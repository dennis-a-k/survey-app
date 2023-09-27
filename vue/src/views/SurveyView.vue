<template>
  <PageComponentVue>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          {{ this.$route.params.id ? model.title : "Создайте опрос" }}
        </h1>

        <button
          class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red-600"
          type="button"
          @click="deleteSurvey()"
          v-if="this.$route.params.id"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 -mt-1 inline-block"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
          Удалить
        </button>
      </div>
    </template>

    <template v-slot:main>
      <div class="flex justify-center" v-if="loading">Загрузка...</div>
      <form class="animate-fade-in-down" @submit.prevent="saveSurvey" v-else>
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6">
            <!-- изображение -->
            <div>
              <label
                for="image"
                class="block text-sm font-medium text-gray-700"
              >
                Изображение
              </label>
              <div class="mt-1 flex items-center">
                <img
                  :src="model.image_url"
                  class="w-64 h-48 object-cover"
                  :alt="model.title"
                  v-if="model.image_url"
                />
                <span
                  class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100"
                  v-else
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-[80%] h-[80%] text-gray-300"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                    />
                  </svg>
                </span>
                <button
                  class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-800"
                  type="button"
                >
                  <input
                    class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                    type="file"
                    id="image"
                    accept="image/*"
                    @change="onImageChoose"
                  />
                  Изменить
                </button>
              </div>
            </div>

            <!-- заголовок -->
            <div>
              <label
                for="title"
                class="block text-sm font-medium text-gray-700"
              >
                Заголовок
              </label>
              <input
                class="mt-1 focus:ring-sky-800 focus:border-sky-800 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                type="text"
                id="title"
                v-model="model.title"
                autocomplete="survey_title"
              />
            </div>

            <!-- описание -->
            <div>
              <label
                for="description"
                class="block text-sm font-medium text-gray-700"
              >
                Описание
              </label>
              <textarea
                class="mt-1 focus:ring-sky-800 focus:border-sky-800 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md"
                rows="3"
                id="description"
                v-model="model.description"
                autocomplete="survey_description"
                placeholder="Описание опроса"
              />
            </div>

            <!-- дата истечения -->
            <div>
              <label
                for="expire_date"
                class="block text-sm font-medium text-gray-700"
              >
                Дата истечения
              </label>
              <input
                class="mt-1 focus:ring-sky-800 focus:border-sky-800 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                type="date"
                id="expire_date"
                v-model="model.expire_date"
              />
            </div>

            <!-- статус -->
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  class="h-4 w-4 focus:ring-sky-800 text-sky-700 border-gray-300 rounded"
                  type="checkbox"
                  v-model="model.status"
                  id="status"
                />
              </div>
              <div class="ml-3 text-sm">
                <label class="font-medium text-gray-700" for="status">
                  Статус активный
                </label>
              </div>
            </div>
          </div>

          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <h3
              class="text-2xl font-semibold flex items-center justify-between"
            >
              Вопросы

              <button
                class="flex items-center text-sm py-2 px-4 rounded-md text-white bg-gray-600 hover:bg-gray-700"
                type="button"
                @click="addQuestion"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-4 h-4 mr-1"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4.5v15m7.5-7.5h-15"
                  />
                </svg>
                Добавить вопрос
              </button>
            </h3>

            <div
              class="text-center text-gray-600"
              v-if="!model.questions.length"
            >
              Нет созданных вопросов
            </div>
            <div
              v-for="(question, index) in model.questions"
              :key="question.id"
            >
              <QuestionEditorVue
                :question="question"
                :index="index"
                @change="questionChange"
                @addQuestion="addQuestion"
                @deleteQuestion="deleteQuestion"
              />
            </div>
          </div>

          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button
              class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm font-medium text-sm rounded-md text-white bg-sky-800 hover:bg-sky-700 focus:ring-2 focus:ring-offset-2 focus:ring-sky-600"
              type="submit"
            >
              Создать
            </button>
          </div>
        </div>
      </form>
    </template>
  </PageComponentVue>
</template>

<script>
import { v4 as uuidv4 } from "uuid";
import PageComponentVue from "../components/PageComponent.vue";
import QuestionEditorVue from "../components/QuestionEditor.vue";
import { computed, watch } from "vue";

export default {
  name: "SurveyView",
  components: {
    PageComponentVue,
    QuestionEditorVue,
  },
  data: () => ({
    model: {
      id: "",
      title: "",
      status: false,
      description: null,
      image_url: null,
      expire_date: null,
      questions: [],
    },
    loading: null,
  }),
  mounted() {
    this.loading = computed(() => this.$store.state.currentSurvey.loading);

    watch(
      () => this.$store.state.currentSurvey.data,
      (newVal, oldVal) => {
        this.model = {
          ...JSON.parse(JSON.stringify(newVal)),
          status: newVal.status !== "draft",
        };
      }
    );

    if (this.$route.params.id) {
      this.$store.dispatch("getSurvey", this.$route.params.id);
    }
  },
  methods: {
    onImageChoose(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = () => {
        this.model.image = reader.result;
        this.model.image_url = reader.result;
      };

      reader.readAsDataURL(file);
    },

    addQuestion(index) {
      const newQuestion = {
        id: uuidv4(),
        type: "text",
        question: "",
        description: null,
        data: {},
      };

      this.model.questions.splice(index, 0, newQuestion);
    },

    deleteQuestion(question) {
      this.model.questions = this.model.questions.filter(
        (q) => q.id !== question.id
      );
    },

    questionChange(question) {
      this.model.questions = this.model.questions.map((q) => {
        if (q.id === question.id) {
          return JSON.parse(JSON.stringify(question));
        }

        return q;
      });
    },

    saveSurvey() {
      this.$store.dispatch("saveSurvey", this.model).then(({ data }) => {
        this.$store.commit("notify", {
          type: "success",
          message: "Опрос успешно обновлён",
        });

        this.$router.push({
          name: "SurveyView",
          params: { id: data.data.id },
        });
      });
    },

    deleteSurvey() {
      if (confirm(`Вы уверены, что хотите удалить этот опрос?`)) {
        this.$store.dispatch("deleteSurvey", this.model.id).then(() => {
          this.$router.push({ name: "Surveys" });
        });
      }
    },
  },
};
</script>
