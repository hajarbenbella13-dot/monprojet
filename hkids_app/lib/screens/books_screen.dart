import 'package:flutter/material.dart';
import 'read_book_screen.dart';

class BooksScreen extends StatelessWidget {
  const BooksScreen({super.key});

  final List<Map<String, dynamic>> books = const [
    {
      "id": 1,
      "titre": "L'aventure de Lion",
      "description": "Un petit lion qui cherche sa maman...",
      "emoji": "🦁",
      "color": Color(0xFFFFEDD5),
      "total_pages": 10,
      "current_page": 10,
    },
    {
      "id": 2,
      "titre": "Le Petit Robot",
      "description": "Apprendre les couleurs avec Bip-Bop.",
      "emoji": "🤖",
      "color": Color(0xFFDBEAFE),
      "total_pages": 8,
      "current_page": 3,
    },
    {
      "id": 3,
      "titre": "Espace Magique",
      "description": "Découvrir les étoiles et la lune.",
      "emoji": "🚀",
      "color": Color(0xFFF3E8FF),
      "total_pages": 5,
      "current_page": 0,
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: [Color(0xFF1E293B), Color(0xFF0F172A)],
          ),
        ),
        child: SafeArea(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildHeader(context),
              Expanded(
                child: ListView.builder(
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  itemCount: books.length,
                  itemBuilder: (context, index) => _buildBookCard(context, books[index]),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeader(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(25.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: const [
              Text("Salut, Adam! 👋",
                  style: TextStyle(color: Colors.white, fontSize: 28, fontWeight: FontWeight.w900)),
              Text("Prêt pour une histoire ?",
                  style: TextStyle(color: Colors.white70, fontSize: 16)),
            ],
          ),
          
          /// 👤 PROFILE MENU (Changer profil / Déconnecter)
          PopupMenuButton<String>(
            icon: Container(
              padding: const EdgeInsets.all(2),
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                border: Border.all(color: Colors.blueAccent, width: 2),
              ),
              child: const CircleAvatar(
                backgroundColor: Colors.white10,
                child: Text("👦", style: TextStyle(fontSize: 20)),
              ),
            ),
            offset: const Offset(0, 50),
            color: const Color(0xFF1E293B),
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
            onSelected: (value) {
              if (value == 'profile') {
                // Logic dyal change profile
                print("Changer Profil");
              } else if (value == 'logout') {
                Navigator.pop(context); // Kat-rejj3o l-login
              }
            },
            itemBuilder: (context) => [
              const PopupMenuItem(
                value: 'profile',
                child: ListTile(
                  leading: Icon(Icons.person_outline, color: Colors.white),
                  title: Text("Changer Profil", style: TextStyle(color: Colors.white)),
                ),
              ),
              const PopupMenuItem(
                value: 'logout',
                child: ListTile(
                  leading: Icon(Icons.logout, color: Colors.redAccent),
                  title: Text("Déconnecter", style: TextStyle(color: Colors.redAccent)),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildBookCard(BuildContext context, Map<String, dynamic> book) {
    double progress = book['current_page'] / book['total_pages'];
    bool isFinished = book['current_page'] == book['total_pages'];

    return Container(
      margin: const EdgeInsets.only(bottom: 20),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.08),
        borderRadius: BorderRadius.circular(30),
        border: Border.all(color: Colors.white10),
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(30),
        child: IntrinsicHeight(
          child: Row(
            children: [
              Container(
                width: 100,
                color: book['color'],
                child: Center(child: Text(book['emoji'], style: const TextStyle(fontSize: 50))),
              ),
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(book['titre'],
                          style: const TextStyle(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold)),
                      const SizedBox(height: 5),
                      Text(book['description'],
                          style: const TextStyle(color: Colors.white60, fontSize: 12), maxLines: 1),
                      const Spacer(),
                      Row(
                        children: [
                          Expanded(
                            child: ClipRRect(
                              borderRadius: BorderRadius.circular(10),
                              child: LinearProgressIndicator(
                                value: progress,
                                minHeight: 6,
                                backgroundColor: Colors.white10,
                                valueColor: AlwaysStoppedAnimation<Color>(
                                    isFinished ? Colors.greenAccent : Colors.orangeAccent),
                              ),
                            ),
                          ),
                          const SizedBox(width: 10),
                          Text("${(progress * 100).toInt()}%",
                              style: const TextStyle(color: Colors.white38, fontSize: 10)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      SizedBox(
                        width: double.infinity,
                        child: ElevatedButton(
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => ReadBookScreen(book: book),
                              ),
                            );
                          },
                          style: ElevatedButton.styleFrom(
                            backgroundColor: isFinished ? Colors.greenAccent : Colors.white,
                            foregroundColor: Colors.black,
                            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                            padding: const EdgeInsets.symmetric(vertical: 0),
                          ),
                          child: Text(isFinished ? "Relire 🔄" : (progress > 0 ? "Continuer" : "Lire 📖"),
                              style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 12)),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}