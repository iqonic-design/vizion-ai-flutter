# Vizion AI (Open Source)

**All-in-one AI creative toolkit Built by Iqonic Design**

Vizion AI is a unified platform to amplify your creative workflows using AI. Generate content, create artwork, enhance photos, build chatbots, or transcribe speech — all from one system.

---

## 🚀 Features

- **AI Content Generation** – articles, blogs, marketing copy  
- **AI ART Generator** – turn text prompts into visuals  
- **Photo Enhancer** – improve image quality automatically  
- **Image Tagging & Description** – generate smart metadata  
- **AI Chatbot** – conversational assistant  
- **Speech to Text** – convert audio into text  
- **Custom Templates** – reusable styles & prompts  
- **Subscription Model** – unlock premium features  

---

## 🧩 Requirements

- **Flutter SDK 3.35.x** (with Dart 3.9.0 bundled)  
- **IDE**: Android Studio / VS Code / IntelliJ  
- **Device setup**  
  - Android → Android Studio Narwhal 3 Feature Drop | 2025.1.3 + AVD or real device  
  - iOS → macOS with Xcode 16.3
- **Firebase account** (for social login, chat, push notifications)  
- **Dependencies** managed via `pubspec.yaml`  
- **Git** (recommended for version control)  

---

## 🔑 API Keys

Vizion AI uses **OpenAI** for AI generation features.

1. Log in or sign up at [OpenAI](https://platform.openai.com/)  
2. Create an API key from your dashboard  
3. In your Admin Dashboard → **Settings → App Configuration**, enable **ChatGPT**  
4. Paste the key into the `ChatGPT_key` field  

---

## ⚡ Quick Start

1. **Clone the repo**

```bash
git clone https://github.com/yourorg/vizion-ai.git
cd vizion-ai
````

2. **Install dependencies**

```bash
flutter pub get
```

3. **Configure**

Copy `.env.example → .env` and update keys:

```
OPENAI_API_KEY=your_api_key
FIREBASE_PROJECT_ID=your_project
```

4. **Run the app**

```bash
flutter run
```

---

## 📂 Project Structure

```
/lib              → Flutter app source
/server           → Backend API & inference
/config           → App & API configuration
/assets           → Media & static files
```

---

## ⚙️ Flutter App Configuration

### Changing The App's Name

`lib/configs.dart`

```dart
const APP_NAME = 'YOUR APP NAME';
```

### Reconfiguring The Server URL

```dart
const DOMAIN_URL = "ADD YOUR DOMAIN URL";
```

### Changing The Default Language

```dart
const DEFAULT_LANGUAGE = "LANGUAGE CODE"; // e.g. "en", "ar", "de", "pt", "es"
```

### Changing The App Font

`lib/app_theme.dart`

```dart
fontFamily: GoogleFonts.FONT_NAME().fontFamily,
textTheme: GoogleFonts.FONT_NAMETextTheme(),
```

### Changing Primary & Secondary Color

`lib/utils/colors.dart`

```dart
var primaryColor = Color(0xFF586AEA);
var secondaryColor = Color(0xFFD6FF79);
```

### Set up AdMob

`lib/configs.dart`

```dart
const String interstitialAdId = 'YOUR_INTERSTITIAL_AD_ID';
const String nativeAdId = 'YOUR_NATIVE_AD_ID';
const String bannerAdId = 'YOUR_BANNER_AD_ID';
const String openAdId = 'YOUR_OPEN_AD_ID';
const String rewardedAdId = 'YOUR_REWARDED_AD_ID';
const String rewardInterstitialAdId = 'YOUR_REWARD_INTERSTITIAL_AD_ID';
```

Update App ID in:

* `AndroidManifest.xml`
* `Info.plist`

### Add FirebaseOptions

`lib/firebase_options.dart`

```dart
final FirebaseOptions firebaseConfig = FirebaseOptions(
  apiKey: 'FIREBASE API KEY',
  appId: isIOS ? 'FIREBASE iOS APP ID':'FIREBASE ANDROID APP ID',
  projectId: 'FIREBASE PROJECT ID',
  messagingSenderId: 'FIREBASE SENDER ID',
  storageBucket: 'FIREBASE STORAGE BUCKET',
  iosBundleId: 'FIREBASE iOS APP BUNDLE ID',
);
```
---

## 🤝 Contributing

We welcome contributions!

* Fork the repo
* Create a new branch
* Commit your changes
* Submit a PR 🎉

---

## 📜 License

This project is licensed under the **MIT License**.
See the [LICENSE](LICENSE) file for details.

---

Built with ❤️ by Iqonic Design
