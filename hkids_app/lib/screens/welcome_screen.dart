import 'dart:math';
import 'package:flutter/material.dart';
import 'auth_screen.dart'; 
import 'adminlogin_screen.dart'; 

class WelcomeScreen extends StatefulWidget {
  const WelcomeScreen({super.key});

  @override
  _WelcomeScreenState createState() => _WelcomeScreenState();
}

class _WelcomeScreenState extends State<WelcomeScreen> with SingleTickerProviderStateMixin {
  late AnimationController _controller;
  final Random _random = Random();

  @override
  void initState() {
    super.initState();
    // Animation dyal n-joum bach i-bqa i-brille (scintillation)
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
          // 1. L-khalfya l-liliya (Gradient)
          Container(
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                colors: [Color(0xFF0F172A), Color(0xFF1E1E50), Color(0xFF000000)],
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
              ),
            ),
          ),

          // 2. Tbaqa dyal n-joum (Animated Stars)
          ...List.generate(45, (index) {
            return AnimatedStar(
              controller: _controller,
              top: _random.nextDouble() * MediaQuery.of(context).size.height,
              left: _random.nextDouble() * MediaQuery.of(context).size.width,
              size: _random.nextDouble() * 8 + 3,
              delay: _random.nextDouble(),
            );
          }),

          // 3. L-mo7tawa l-asassi (UI)
          SafeArea(
            child: Padding(
              padding: const EdgeInsets.all(24.0),
              child: Column(
                children: [
                  // L-foq: Logo o l-bouton dyal Admin
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Row(
                        children: [
                          ClipRRect(
                            borderRadius: BorderRadius.circular(8),
                            child: Image.asset(
                              'images/logo.jpg', 
                              height: 40, 
                              errorBuilder: (c, e, s) => const Icon(Icons.star, color: Colors.yellowAccent),
                            ),
                          ),
                          const SizedBox(width: 10),
                          const Text(
                            "PetitLecteur",
                            style: TextStyle(
                              fontSize: 22, 
                              fontWeight: FontWeight.bold, 
                              color: Colors.white,
                              letterSpacing: 1.2,
                            ),
                          ),
                        ],
                      ),
                      // Bouton sghir dyal l-Admin
                      IconButton(
                        onPressed: () {
                          Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => AdminLoginScreen()),
                      );
                          print("Mode Admin cliqué");
                        },
                        icon: const Icon(Icons.admin_panel_settings_rounded, color: Colors.white54, size: 28),
                      ),
                    ],
                  ),

                  const SizedBox(height: 50),

                  // L-3onwan l-kbir
                  const Text(
                    'Une petite pause\nmagique avant de dormir',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 32, 
                      fontWeight: FontWeight.bold, 
                      color: Colors.white,
                      height: 1.2,
                    ),
                  ),

                  const SizedBox(height: 30),

                  // Quote Box (Glassmorphism effect)
                  Container(
                    padding: const EdgeInsets.all(20),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.08),
                      borderRadius: BorderRadius.circular(24),
                      border: Border.all(color: Colors.white.withOpacity(0.1)),
                    ),
                    child: const Text(
                      '"Parce que vos journées sont bien remplies, mais que le rituel de la lecture est sacré. PetitLecteur accompagne vos enfants dans leurs rêves les plus doux."',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 16, 
                        fontStyle: FontStyle.italic, 
                        color: Colors.white70,
                        height: 1.5,
                      ),
                    ),
                  ),

                  const Spacer(),

                  // Bouton d-dkhol (CTA)
                  ElevatedButton(
                    onPressed: () {
                      // 💡 Hna 7eyedna 'const' bach may-kounch error m3a AuthScreen
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => AuthScreen()),
                      );
                    },
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.orangeAccent,
                      foregroundColor: Colors.black,
                      padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 20),
                      elevation: 10,
                      shadowColor: Colors.orangeAccent.withOpacity(0.5),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(50)),
                    ),
                    child: const Text(
                      "Commencer l'aventure 🚀", 
                      style: TextStyle(fontSize: 18, fontWeight: FontWeight.w900),
                    ),
                  ),

                  const SizedBox(height: 50),

                  // Logo kbir d-dayer l-ta7t
                  Container(
                    width: 140,
                    height: 140,
                    padding: const EdgeInsets.all(4),
                    decoration: BoxDecoration(
                      shape: BoxShape.circle,
                      color: Colors.white,
                      boxShadow: [
                        BoxShadow(
                          color: Colors.blueAccent.withOpacity(0.3), 
                          blurRadius: 40, 
                          spreadRadius: 5
                        )
                      ],
                    ),
                    child: ClipOval(
                      child: Image.asset(
                        'images/logo.jpg', 
                        fit: BoxFit.cover,
                        errorBuilder: (c, e, s) => const Icon(Icons.image, size: 50, color: Colors.grey),
                      ),
                    ),
                  ),
                  const SizedBox(height: 20),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

/// 🌟 Class dyal n-joum lli kat-t-7arrak
class AnimatedStar extends StatelessWidget {
  final AnimationController controller;
  final double top;
  final double left;
  final double size;
  final double delay;

  const AnimatedStar({
    super.key, 
    required this.controller, 
    required this.top, 
    required this.left, 
    required this.size, 
    required this.delay,
  });

  @override
  Widget build(BuildContext context) {
    return Positioned(
      top: top,
      left: left,
      child: AnimatedBuilder(
        animation: controller,
        builder: (context, child) {
          // Scintillation logic
          double opacity = (sin((controller.value + delay) * 2 * pi) + 1) / 2;
          return Opacity(
            opacity: opacity.clamp(0.1, 0.8),
            child: Icon(
              Icons.star,
              size: size,
              color: Colors.yellowAccent,
            ),
          );
        },
      ),
    );
  }
}