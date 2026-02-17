import 'dart:math';
import 'package:flutter/material.dart';
import 'auth_screen.dart';


class WelcomeScreen extends StatefulWidget {
  @override
  _WelcomeScreenState createState() => _WelcomeScreenState();
}

class _WelcomeScreenState extends State<WelcomeScreen> with SingleTickerProviderStateMixin {
  late AnimationController _controller;
  final Random _random = Random();

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 1),
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
          // 1. الخلفية الليلية المتدرجة
          Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [Color(0xFF0F172A), Color(0xFF1E1E50), Color(0xFF000000)],
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
              ),
            ),
          ),

          // 2. طبقة النجوم الصفراء (خلف المحتوى)
          ...List.generate(40, (index) {
            return AnimatedStar(
              controller: _controller,
              top: _random.nextDouble() * MediaQuery.of(context).size.height,
              left: _random.nextDouble() * MediaQuery.of(context).size.width,
              size: _random.nextDouble() * 10 + 4,
              delay: _random.nextDouble(),
            );
          }),

          // 3. المحتوى الأساسي (UI Content)
          SafeArea(
            child: Padding(
              padding: const EdgeInsets.all(24.0),
              child: Column(
                children: [
                  // Logo + Title (Top)
                  Row(
                    children: [
                      // محاولة عرض اللوكو الصغير فوق
                      Image.asset(
                        'images/logo.jpg', 
                        height: 40, 
                        errorBuilder: (c, e, s) => Icon(Icons.star_border, color: Colors.yellowAccent)
                      ),
                      SizedBox(width: 8),
                      Text(
                        "PetitLecteur",
                        style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Colors.white),
                      ),
                    ],
                  ),
                  SizedBox(height: 40),

                  Text(
                    'Une petite pause\nmagique avant de dormir',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 34, 
                      fontWeight: FontWeight.bold, 
                      color: Colors.white,
                      shadows: [Shadow(color: Colors.blueAccent.withOpacity(0.5), blurRadius: 20)],
                    ),
                  ),
                  SizedBox(height: 30),
                  
                  // Quote Box
                  Container(
                    padding: EdgeInsets.all(20),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.08),
                      borderRadius: BorderRadius.circular(24),
                      border: Border.all(color: Colors.white.withOpacity(0.1)),
                    ),
                    child: Text(
                      '"Parce que vos journées sont bien remplies, mais que le rituel de la lecture est sacré. PetitLecteur accompagne vos enfants dans leurs rêves les plus doux."',
                      textAlign: TextAlign.center,
                      style: TextStyle(fontSize: 16, fontStyle: FontStyle.italic, color: Colors.white),
                    ),
                  ),
                  
                  Spacer(),
                  
                  // زر البدء
                  ElevatedButton(
                    onPressed: () {
  Navigator.push(
    context,
    MaterialPageRoute(
      builder: (context) => AuthScreen(),
    ),
  );
},

                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.orangeAccent,
                      padding: EdgeInsets.symmetric(horizontal: 50, vertical: 20),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(50)),
                    ),
                    child: Text("Commencer l'aventure 🚀", 
                      style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black)),
                  ),
                  
                  SizedBox(height: 40),
                  
                  // اللوكو الدائري الكبير (المحسن)
                  Container(
                    width: 150,
                    height: 150,
                    padding: EdgeInsets.all(4), // إطار خارجي رقيق
                    decoration: BoxDecoration(
                      shape: BoxShape.circle,
                      color: Colors.white, // خلفية بيضاء سادة لضمان ظهور اللوكو
                      boxShadow: [
                        BoxShadow(color: Colors.blue.withOpacity(0.4), blurRadius: 30, spreadRadius: 5)
                      ],
                    ),
                    child: ClipOval(
                      child: Image.asset(
                        'images/logo.jpg',
                        fit: BoxFit.cover,
                        errorBuilder: (context, error, stackTrace) {
                          return Icon(Icons.image_not_supported, color: Colors.grey, size: 50);
                        },
                      ),
                    ),
                  ),
                  SizedBox(height: 10),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class AnimatedStar extends StatelessWidget {
  final AnimationController controller;
  final double top;
  final double left;
  final double size;
  final double delay;

  AnimatedStar({required this.controller, required this.top, required this.left, required this.size, required this.delay});

  @override
  Widget build(BuildContext context) {
    return Positioned(
      top: top,
      left: left,
      child: AnimatedBuilder(
        animation: controller,
        builder: (context, child) {
          double opacity = (sin((controller.value + delay) * 2 * pi) + 1) / 2;
          return Opacity(
            opacity: opacity.clamp(0.2, 0.7),
            child: Icon(
              Icons.star,
              size: size,
              color: Colors.yellowAccent,
              shadows: [Shadow(color: Colors.orange, blurRadius: size)],
            ),
          );
        },
      ),
    );
  }
}