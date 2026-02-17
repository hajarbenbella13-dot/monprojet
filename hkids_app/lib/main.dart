import 'package:flutter/material.dart';
import 'screens/welcome_screen.dart'; // Import لصفحة الترحيب الجديدة

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Kids Reading App',
      theme: ThemeData(useMaterial3: true),
      home:  WelcomeScreen(), 
    );
  }
}