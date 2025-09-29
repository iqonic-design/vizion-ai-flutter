import { createRouter, createWebHashHistory } from 'vue-router'
import SettingLayout from '@/Setting/SettingLayout.vue'
import GeneralPage from '@/Setting/SectionPages/GeneralPage.vue'
import MetaPage from '@/Setting/SectionPages/MetaPage.vue'
import AnalyticsPage from '@/Setting/SectionPages/AnalyticsPage.vue'
import CustomCodePage from '@/Setting/SectionPages/CustomCodePage.vue'
import CustomizationPage from '@/Setting/SectionPages/CustomizationPage.vue'
import MobilePage from '@/Setting/SectionPages/MobilePage.vue'
import MailPage from '@/Setting/SectionPages/MailPage.vue'
import NotificationSetting from '@/Setting/SectionPages/NotificationSetting.vue'
import IntegrationPage from '@/Setting/SectionPages/IntegrationPage.vue'
import CustomFieldsPage from '@/Setting/SectionPages/CustomFieldsPage.vue'
import CurrencySettingPage from '@/Setting/SectionPages/CurrencySettingPage.vue'
import PaymentMethod from '@/Setting/SectionPages/PaymentMethod.vue'
import LanguagePage from '@/Setting/SectionPages/LanguagePage.vue'
import MiscSettingPage from '@/Setting/SectionPages/MiscSettingPage.vue'
import OtherSetting from '@/Setting/SectionPages/OtherSetting.vue'
import PushNotificationPage from '@/Setting/SectionPages/PushNotificationPage.vue'

const routes = [
  {
    path: '/',
    component: SettingLayout,
    children: [
      {
        path: '',
        name: 'Settings.home',
        component: GeneralPage
      },
      {
        path: 'misc-setting',
        name: 'Settings.misc',
        component: MiscSettingPage
      },
     
      {
        path: 'meta',
        name: 'Settings.meta',
        component: MetaPage
      },
      {
        path: 'analitics',
        name: 'Settings.analitics',
        component: AnalyticsPage
      },
      {
        path: 'custom-code',
        name: 'Settings.custom-code',
        component: CustomCodePage
      },
      {
        path: 'customization',
        name: 'Settings.customization',
        component: CustomizationPage
      },
      {
        path: 'mobile',
        name: 'Settings.mobile',
        component: MobilePage
      },
      {
        path: 'mail',
        name: 'Settings.mail',
        component: MailPage
      },
      {
        path: 'notificationsetting',
        name: 'Settings.notificationsetting',
        component: NotificationSetting
      },
      {
        path: 'integration',
        name: 'Settings.integration',
        component: IntegrationPage
      },
      {
        path: 'custom-fields',
        name: 'Settings.custom-fields',
        component: CustomFieldsPage
      },
      {
        path: 'currency-settings',
        name: 'Settings.currency-settings',
        component: CurrencySettingPage
      },
      {
        path: 'payment-method',
        name: 'Settings.payment-method',
        component: PaymentMethod
      },
      {
        path: 'language-settings',
        name: 'Settings.language-settings',
        component: LanguagePage
      },
      {
        path: 'other-settings',
        name: 'Settings.other-settings',
        meta: {permission: 'setting_menu_builder'},
        component: OtherSetting
      },
      {
        path: 'push-notification',
        name: 'Settings.push-notification',
        component: PushNotificationPage
      }
    ]
  }
]


export const router = createRouter({
  linkActiveClass: '',
  linkExactActiveClass: 'active',
  history: createWebHashHistory(),
  routes
})

