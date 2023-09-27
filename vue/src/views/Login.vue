<template>
  <div>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img
        class="mx-auto h-10 w-auto"
        src="../assets/images/free-icon-notebook-6780593.png"
        alt="Your Company"
      />
      <h2
        class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
      >
        Авторизация
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="login">
        <div
          v-if="errors"
          class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded"
        >
          {{ errors }}
          <span
            class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
            @click="errors = ''"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </span>
        </div>

        <div>
          <label
            for="email"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Почта
          </label>
          <div class="mt-2">
            <input
              id="email"
              v-model="user.email"
              type="email"
              autocomplete="email"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-800 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label
              for="password"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Пароль
            </label>
          </div>
          <div class="mt-2">
            <input
              id="password"
              v-model="user.password"
              type="password"
              autocomplete="current-password"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-800 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label
              for="remember"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Запомнить
            </label>
          </div>
          <div class="mt-2">
            <input
              id="remember"
              v-model="user.remember"
              type="checkbox"
              autocomplete="current-password"
              class="w-4 h-4 text-sky-800 focus:ring-sky-800 border-gray-300 rounded"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-sky-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-sky-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-800"
          >
            Войти
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        <router-link
          :to="{ name: 'Register' }"
          class="font-semibold leading-6 text-sky-800 hover:text-sky-700"
          >Регистрация
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data: () => ({
    user: {
      email: "",
      password: "",
      remember: false,
    },
    errors: "",
  }),
  methods: {
    login() {
      this.$store
        .dispatch("login", this.user)
        .then((res) => {
          this.$router.push({ name: "Dashboard" });
        })
        .catch((error) => {
          this.errors = error.response.data.message;
        });
    },
  },
};
</script>
