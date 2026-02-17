import 'package:flutter/material.dart';
import 'dart:math';

class AuthScreen extends StatefulWidget {
  @override
  _AuthScreenState createState() => _AuthScreenState();
}

class _AuthScreenState extends State<AuthScreen> with SingleTickerProviderStateMixin {
  bool isLogin = true; // للتحكم بين واجهة الدخول وإنشاء حساب
  String selectedAge = "2-5";
  late AnimationController _controller;
  final Random _random = Random();

  @override
  void initState() {
    super.initState();
    // إعداد حركة النجوم فـ الخلفية
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 2),
    )..repeat(reverse: true);
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      body: Stack(
        children: [
          // 1. الخلفية المتدرجة (Gradient)
          _buildBackground(),

          // 2. طبقة النجوم الصفرين المتحركة
          ...List.generate(40, (index) => _buildAnimatedStar()),

          // 3. المحتوى الأساسي (Login / Register Card)
          Center(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(24),
              child: AnimatedSwitcher(
                duration: const Duration(milliseconds: 500),
                transitionBuilder: (child, animation) => FadeTransition(
                  opacity: animation,
                  child: ScaleTransition(scale: animation, child: child),
                ),
                child: isLogin ? _buildLoginCard() : _buildRegisterCard(),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // --- واجهة تسجيل الدخول (Je me connecte) ---
  Widget _buildLoginCard() {
    return Container(
      key: const ValueKey(1),
      padding: const EdgeInsets.all(32),
      decoration: _cardDecoration(),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          _buildHeader("🔑", "Je me connecte", "Content de te revoir !"),
          const SizedBox(height: 30),
          _buildTextField("Ton joli prénom", "Ex: Adam"),
          const SizedBox(height: 20),
          _buildPinField("Ton Code PIN secret"),
          const SizedBox(height: 30),
          _buildMainButton("C'est parti ! 🚀", () {
            // كود تسجيل الدخول هنا
          }),
          const SizedBox(height: 10),
          _buildSwitchButton(
            "Tu n'as pas encore de profil ?", 
            "Créer mon compte ✨", 
            () => setState(() => isLogin = false)
          ),
        ],
      ),
    );
  }

  // --- واجهة إنشاء حساب (Nouveau Lecteur) ---
  Widget _buildRegisterCard() {
    return Container(
      key: const ValueKey(2),
      padding: const EdgeInsets.all(32),
      decoration: _cardDecoration(),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          _buildHeader("🐣", "Nouveau Lecteur", "Crée ton profil en 2s !"),
          const SizedBox(height: 25),
          _buildTextField("Comment t'appelles-tu ?", "Ex: Inès"),
          const SizedBox(height: 15),
          _buildPinField("Ton futur PIN (4 chiffres)"),
          const SizedBox(height: 20),
          _buildAgePicker(),
          const SizedBox(height: 30),
          _buildMainButton("Créer mon profil 🌟", () {
            // كود الحفظ هنا
          }),
          const SizedBox(height: 15),
          // زر الرجوع في حالة ما بغاش يكريي بروفايل
          TextButton(
            onPressed: () => setState(() => isLogin = true),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: const [
                Icon(Icons.arrow_back_ios, size: 14, color: Colors.white70),
                SizedBox(width: 8),
                Text(
                  "Retour à la connexion",
                  style: TextStyle(
                    color: Colors.white70, 
                    fontWeight: FontWeight.bold,
                    decoration: TextDecoration.underline,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // --- Widgets المساعدة للزواق والترتيب ---

  BoxDecoration _cardDecoration() {
    return BoxDecoration(
      color: Colors.white.withOpacity(0.12),
      borderRadius: BorderRadius.circular(40),
      border: Border.all(color: Colors.white.withOpacity(0.2)),
      boxShadow: const [BoxShadow(color: Colors.black26, blurRadius: 20)],
    );
  }

  Widget _buildHeader(String emoji, String title, String sub) {
    return Column(
      children: [
        Text(emoji, style: const TextStyle(fontSize: 50)),
        const SizedBox(height: 10),
        Text(title, style: const TextStyle(fontSize: 24, fontWeight: FontWeight.w900, color: Colors.white, letterSpacing: -1)),
        Text(sub, style: const TextStyle(color: Colors.white60, fontWeight: FontWeight.bold)),
      ],
    );
  }

  Widget _buildTextField(String label, String hint) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label.toUpperCase(), style: TextStyle(color: Colors.indigo[200], fontSize: 10, fontWeight: FontWeight.w900, letterSpacing: 2)),
        const SizedBox(height: 8),
        TextField(
          textAlign: TextAlign.center,
          style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
          decoration: InputDecoration(
            hintText: hint,
            hintStyle: const TextStyle(color: Colors.white24),
            filled: true,
            fillColor: Colors.white.withOpacity(0.05),
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(20), borderSide: BorderSide.none),
          ),
        ),
      ],
    );
  }

  Widget _buildPinField(String label) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label.toUpperCase(), style: TextStyle(color: Colors.indigo[200], fontSize: 10, fontWeight: FontWeight.w900, letterSpacing: 2)),
        const SizedBox(height: 8),
        TextField(
          obscureText: true,
          maxLength: 4,
          textAlign: TextAlign.center,
          keyboardType: TextInputType.number,
          style: const TextStyle(color: Colors.orangeAccent, fontSize: 32, fontWeight: FontWeight.w900, letterSpacing: 20),
          decoration: InputDecoration(
            counterText: "",
            filled: true,
            fillColor: Colors.white.withOpacity(0.05),
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(20), borderSide: BorderSide.none),
          ),
        ),
      ],
    );
  }

  Widget _buildAgePicker() {
    return Row(
      children: [
        _ageOption("🐥", "2-5 ans", "2-5"),
        const SizedBox(width: 15),
        _ageOption("🦁", "6-10 ans", "6-10"),
      ],
    );
  }

  Widget _ageOption(String emoji, String label, String value) {
    bool isSelected = selectedAge == value;
    return Expanded(
      child: GestureDetector(
        onTap: () => setState(() => selectedAge = value),
        child: AnimatedContainer(
          duration: const Duration(milliseconds: 200),
          padding: const EdgeInsets.symmetric(vertical: 15),
          decoration: BoxDecoration(
            color: isSelected ? Colors.indigo.withOpacity(0.4) : Colors.white.withOpacity(0.05),
            borderRadius: BorderRadius.circular(25),
            border: Border.all(color: isSelected ? Colors.indigoAccent : Colors.white10, width: 2),
          ),
          child: Column(
            children: [
              Text(emoji, style: const TextStyle(fontSize: 30)),
              Text(label, style: const TextStyle(color: Colors.white, fontSize: 12, fontWeight: FontWeight.bold)),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildMainButton(String text, VoidCallback onTap) {
    return SizedBox(
      width: double.infinity,
      height: 60,
      child: ElevatedButton(
        onPressed: onTap,
        style: ElevatedButton.styleFrom(
          backgroundColor: Colors.white,
          foregroundColor: Colors.indigo[900],
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
          elevation: 8,
          shadowColor: Colors.indigo.withOpacity(0.5),
        ),
        child: Text(text, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w900)),
      ),
    );
  }

  Widget _buildSwitchButton(String text, String action, VoidCallback onTap) {
    return Column(
      children: [
        Text(text, style: const TextStyle(color: Colors.white54, fontSize: 13)),
        TextButton(
          onPressed: onTap, 
          child: Text(action, style: const TextStyle(color: Colors.orangeAccent, fontWeight: FontWeight.w900))
        ),
      ],
    );
  }

  Widget _buildBackground() {
    return Container(
      decoration: const BoxDecoration(
        gradient: LinearGradient(
          colors: [Color(0xFF0F172A), Color(0xFF1E1E50), Color(0xFF000000)],
          begin: Alignment.topCenter,
          end: Alignment.bottomCenter,
        ),
      ),
    );
  }

  Widget _buildAnimatedStar() {
    double top = _random.nextDouble() * 800;
    double left = _random.nextDouble() * 450;
    double size = _random.nextDouble() * 10 + 2;
    double delay = _random.nextDouble();

    return Positioned(
      top: top,
      left: left,
      child: AnimatedBuilder(
        animation: _controller,
        builder: (context, child) {
          double opacity = (sin((_controller.value + delay) * 2 * pi) + 1) / 2;
          return Opacity(
            opacity: opacity.clamp(0.1, 0.7),
            child: Icon(Icons.star, color: Colors.yellowAccent, size: size),
          );
        },
      ),
    );
  }
}