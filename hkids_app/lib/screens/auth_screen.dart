import 'package:flutter/material.dart';
import 'books_screen.dart';
import 'dart:math';
import 'dart:ui';

class AuthScreen extends StatefulWidget {
  @override
  _AuthScreenState createState() => _AuthScreenState();
}

class _AuthScreenState extends State<AuthScreen> with SingleTickerProviderStateMixin {
  bool isLogin = true;
  String selectedAge = "2-5";
  late AnimationController _controller;
  final Random _random = Random();

  // Controller باش نشدو السمية من الحقل
  final TextEditingController _nameController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this, 
      duration: const Duration(seconds: 2)
    )..repeat(reverse: true);
  }

  @override
  void dispose() {
    _controller.dispose();
    _nameController.dispose();
    super.dispose();
  }

  // دالة إنشاء البروفايل والترحيب
  void _handleCreateProfile() {
    String name = _nameController.text.trim();
    if (name.isEmpty) name = "Petit Lecteur";

    // ميساج الترحيب
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text("✨ Bienvenue, $name ! ✨", textAlign: TextAlign.center),
        backgroundColor: Colors.indigoAccent,
        behavior: SnackBarBehavior.floating,
        duration: const Duration(seconds: 2),
      ),
    );

    // الرجوع للـ Login
    setState(() => isLogin = true);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      body: Stack(
        children: [
          _buildBackground(),
          ...List.generate(35, (index) => _buildAnimatedStar()),
          Center(
            child: Padding(
              padding: const EdgeInsets.all(20),
              child: ClipRRect(
                borderRadius: BorderRadius.circular(40),
                child: BackdropFilter(
                  filter: ImageFilter.blur(sigmaX: 10, sigmaY: 10),
                  child: AnimatedSwitcher(
                    duration: const Duration(milliseconds: 500),
                    child: isLogin ? _buildLoginCard() : _buildRegisterCard(),
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // ================= واجهة تسجيل الدخول =================
  Widget _buildLoginCard() {
    return Container(
      key: const ValueKey(1),
      padding: const EdgeInsets.all(28),
      decoration: _cardDecoration(),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          _buildHeader("🔑", "Je me connecte", "Ravi de te revoir !"),
          const SizedBox(height: 25),
          _buildTextField("Ton joli prénom", "Ex: Adam", null),
          const SizedBox(height: 15),
          _buildPinField("Ton PIN secret"),
          const SizedBox(height: 25),
         _buildMainButton("C'est parti ! 🚀", () {
  Navigator.push(
    context,
    MaterialPageRoute(builder: (context) => const BooksScreen()),
  );
}),
const SizedBox(height: 10),
          _buildSwitchButton(
            "Tu n'as pas de profil ?", 
            "Créer mon compte ✨", 
            () => setState(() => isLogin = false)
          ),
        ],
      ),
    );
  }

  // ================= واجهة إنشاء حساب (Compact - No Scroll) =================
  Widget _buildRegisterCard() {
    return Container(
      key: const ValueKey(2),
      padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 20),
      decoration: _cardDecoration(),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          _buildHeader("🐣", "Nouveau Lecteur", "En 2 secondes !"),
          const SizedBox(height: 15),
          _buildTextField("Ton Prénom", "Ex: Inès", _nameController),
          const SizedBox(height: 10),
          _buildPinField("Ton futur PIN"),
          const SizedBox(height: 15),
          _buildAgePicker(),
          const SizedBox(height: 20),
          _buildMainButton("Créer mon profil 🌟", _handleCreateProfile),
          const SizedBox(height: 12),
          
          // رابط الرجوع للـ Login
          GestureDetector(
            onTap: () => setState(() => isLogin = true),
            child: Text(
              "Annuler / Retour",
              style: TextStyle(
                color: Colors.white.withOpacity(0.5),
                fontWeight: FontWeight.bold,
                decoration: TextDecoration.underline,
                fontSize: 13,
              ),
            ),
          ),
        ],
      ),
    );
  }

  // ================= الأدوات المساعدة (Widgets) =================

  BoxDecoration _cardDecoration() {
    return BoxDecoration(
      color: Colors.white.withOpacity(0.1),
      borderRadius: BorderRadius.circular(40),
      border: Border.all(color: Colors.white.withOpacity(0.2)),
    );
  }

  Widget _buildHeader(String emoji, String title, String sub) {
    return Column(
      children: [
        Text(emoji, style: const TextStyle(fontSize: 40)),
        const SizedBox(height: 5),
        Text(title, style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w900, color: Colors.white)),
        Text(sub, style: const TextStyle(color: Colors.white60, fontSize: 12)),
      ],
    );
  }

  Widget _buildTextField(String label, String hint, TextEditingController? controller) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label.toUpperCase(), style: TextStyle(color: Colors.indigo[100], fontSize: 9, fontWeight: FontWeight.w900, letterSpacing: 1.5)),
        const SizedBox(height: 6),
        TextField(
          controller: controller,
          textAlign: TextAlign.center,
          style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
          decoration: InputDecoration(
            hintText: hint,
            hintStyle: const TextStyle(color: Colors.white24, fontSize: 13),
            filled: true,
            fillColor: Colors.white.withOpacity(0.05),
            contentPadding: const EdgeInsets.symmetric(vertical: 15),
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(15), borderSide: BorderSide.none),
          ),
        ),
      ],
    );
  }

  Widget _buildPinField(String label) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label.toUpperCase(), style: TextStyle(color: Colors.indigo[100], fontSize: 9, fontWeight: FontWeight.w900, letterSpacing: 1.5)),
        const SizedBox(height: 6),
        TextField(
          obscureText: true,
          maxLength: 4,
          textAlign: TextAlign.center,
          keyboardType: TextInputType.number,
          style: const TextStyle(color: Colors.orangeAccent, fontSize: 24, fontWeight: FontWeight.w900, letterSpacing: 10),
          decoration: InputDecoration(
            counterText: "",
            filled: true,
            fillColor: Colors.white.withOpacity(0.05),
            contentPadding: const EdgeInsets.symmetric(vertical: 10),
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(15), borderSide: BorderSide.none),
          ),
        ),
      ],
    );
  }

  Widget _buildAgePicker() {
    return Row(
      children: [
        _ageOption("🐥", "2-5 ans", "2-5"),
        const SizedBox(width: 12),
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
          padding: const EdgeInsets.symmetric(vertical: 10),
          decoration: BoxDecoration(
            color: isSelected ? Colors.indigo.withOpacity(0.4) : Colors.white.withOpacity(0.05),
            borderRadius: BorderRadius.circular(20),
            border: Border.all(color: isSelected ? Colors.indigoAccent : Colors.white10),
          ),
          child: Column(
            children: [
              Text(emoji, style: const TextStyle(fontSize: 24)),
              Text(label, style: const TextStyle(color: Colors.white, fontSize: 11)),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildMainButton(String text, VoidCallback onTap) {
    return Container(
      width: double.infinity,
      height: 55,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(18),
        boxShadow: [
          BoxShadow(color: Colors.indigo.withOpacity(0.2), blurRadius: 10, offset: const Offset(0, 5)),
        ],
      ),
      child: ElevatedButton(
        onPressed: onTap,
        style: ElevatedButton.styleFrom(
          backgroundColor: Colors.white,
          foregroundColor: Colors.indigo[900],
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(18)),
          elevation: 0,
        ),
        child: Text(text, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w900)),
      ),
    );
  }

  Widget _buildSwitchButton(String text, String action, VoidCallback onTap) {
    return Column(
      children: [
        Text(text, style: const TextStyle(color: Colors.white54, fontSize: 12)),
        TextButton(
          onPressed: onTap,
          child: Text(action, style: const TextStyle(color: Colors.orangeAccent, fontSize: 14, fontWeight: FontWeight.w900)),
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
    double left = _random.nextDouble() * 1200; // وسعنا النجوم للويب
    double size = _random.nextDouble() * 6 + 2;
    double delay = _random.nextDouble();

    return Positioned(
      top: top,
      left: left,
      child: AnimatedBuilder(
        animation: _controller,
        builder: (context, child) {
          double opacity = (sin((_controller.value + delay) * 2 * pi) + 1) / 2;
          return Opacity(
            opacity: opacity.clamp(0.1, 0.6),
            child: Icon(Icons.star, color: Colors.yellowAccent, size: size),
          );
        },
      ),
    );
  }
}