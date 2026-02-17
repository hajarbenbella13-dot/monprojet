import 'package:flutter/material.dart';

class LivresScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Liste des Livres"),
        backgroundColor: Colors.indigo,
      ),
      body: Center(
        child: Text(
          "Bienvenue dans la page des livres 📚",
          style: TextStyle(fontSize: 24),
        ),
      ),
    );
  }
}
