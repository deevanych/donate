<template>
  <div>
    <VueHeadFul
      :title="pageTitle"
    />
    <DashboardPageTitle
      :title="pageTitle"
      description="Панель управления">
    </DashboardPageTitle>
    <vs-card style="width: 100%;">
      <template #img>
        <lottie class="lottie__money"
                :options="defaultOptions"
                :height="400"
                :width="400"
                @animCreated="handleAnimation"/>
        <div class="slider__item">
          <div class="slider__wrapper p-5">
            <h1>
              <animated-number
              :value="BALANCE"
              :round="1"
              :duration="1000"
            />₽
            </h1>
            <span>Баланс</span>
          </div>
        </div>
      </template>
    </vs-card>
  </div>
</template>

<script>
import DashboardPageTitle from '@/components/DashboardPageTitle.vue';
import AnimatedNumber from 'animated-number-vue';
import Lottie from 'vue-lottie';
import * as animationData from '@/assets/lottie/money.json';
import { mapGetters } from 'vuex';

export default {
  name: 'IndexPage',
  components: {
    DashboardPageTitle,
    AnimatedNumber,
    Lottie,
  },
  data() {
    return {
      pageTitle: 'Главная',
      defaultOptions: {
        animationData: animationData.default,
      },
    };
  },
  computed: {
    ...mapGetters(['BALANCE']),
  },
  mounted() {
    this.$store.dispatch('GET_BALANCE');
  },
  methods: {
    handleAnimation(anim) {
      this.anim = anim;
      this.anim.setSpeed(0.2);
    },
  },
};
</script>

<style scoped lang="scss">

.vs-card-content::v-deep {

  .vs-card {
    max-width: initial;
    height: 300px;
  }

  .vs-card__img {
    max-height: initial;
    height: 100%;
    overflow: initial;
  }
}

.lottie__money {
  position: absolute;
  right: 0;
  top: -50px;
}

.slider__item {
  background: -webkit-radial-gradient(0% 0%, 103.03% 103.03%, #D080FF 0%, #6C5DD3 100%);
  background: -o-radial-gradient(0% 0%, 103.03% 103.03%, #D080FF 0%, #6C5DD3 100%);
  background: radial-gradient(103.03% 103.03% at 0% 0%, #D080FF 0%, #6C5DD3 100%);
  width: 100%;
  height: 100%;
  border-radius: 25px;

  .slider__wrapper {

    * {
      color: #fff;
      font-weight: bold;
    }

    h1 {
      font-size: 3.5rem;
    }

    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    height: 100%;
  }
}
</style>
