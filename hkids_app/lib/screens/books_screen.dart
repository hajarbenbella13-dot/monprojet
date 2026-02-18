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
      "color": Color(0xFFFFEDD5), // Orange فاتح
      "total_pages": 10,
      "current_page": 10,
    },
    {
      "id": 2,
      "titre": "Le Petit Robot",
      "description": "Apprendre les couleurs avec Bip-Bop.",
      "emoji": "🤖",
      "color": Color(0xFFDBEAFE), // Bleu فاتح
      "total_pages": 8,
      "current_page": 3,
    },
    {
      "id": 3,
      "titre": "Espace Magique",
      "description": "Découvrir les étoiles و القمر المنير.",
      "emoji": "🚀",
      "color": Color(0xFFF3E8FF), // Violet فاتح
      "total_pages": 5,
      "current_page": 0,
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // خلفية متدرجة كتشبه للـ Login ولكن أفتح شوية
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

  // Header فيه الترحيب و زر الخروج
  Widget _buildHeader(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(25.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: const [
              Text("Salut, Adam! 👋", style: TextStyle(color: Colors.white, fontSize: 28, fontWeight: FontWeight.w900)),
              Text("Prêt pour une histoire ?", style: TextStyle(color: Colors.white70, fontSize: 16)),
            ],
          ),
          GestureDetector(
            onTap: () => Navigator.pop(context),
            child: Container(
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(color: Colors.white10, borderRadius: BorderRadius.circular(15)),
              child: const Text("🚪", style: TextStyle(fontSize: 20)),
            ),
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
              // الجزء الملون (صورة الكتاب)
              Container(
                width: 100,
                color: book['color'],
                child: Center(child: Text(book['emoji'], style: const TextStyle(fontSize: 50))),
              ),
              // معلومات الكتاب
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(book['titre'], style: const TextStyle(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold)),
                      const SizedBox(height: 5),
                      Text(book['description'], style: const TextStyle(color: Colors.white60, fontSize: 12), maxLines: 1),
                      const Spacer(),
                      // Progress Bar
                      Row(
                        children: [
                          Expanded(
                            child: ClipRRect(
                              borderRadius: BorderRadius.circular(10),
                              child: LinearProgressIndicator(
                                value: progress,
                                minHeight: 6,
                                backgroundColor: Colors.white10,
                                valueColor: AlwaysStoppedAnimation<Color>(isFinished ? Colors.greenAccent : Colors.orangeAccent),
                              ),
                            ),
                          ),
                          const SizedBox(width: 10),
                          Text("${(progress * 100).toInt()}%", style: const TextStyle(color: Colors.white38, fontSize: 10)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      // زر الإجراء
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