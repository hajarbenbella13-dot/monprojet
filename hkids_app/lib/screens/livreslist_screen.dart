import 'package:flutter/material.dart';
import 'modifierlivre_screen.dart';
import 'ajouterlivre_screen.dart';
import 'indexpage_screen.dart'; 
import 'addpages_screen.dart';

class LivresListScreen extends StatefulWidget {
  const LivresListScreen({super.key});

  @override
  State<LivresListScreen> createState() => _LivresListScreenState();
}

class _LivresListScreenState extends State<LivresListScreen> {
  final List<Map<String, dynamic>> livres = [
    {
      "id": 1, 
      "titre": "Le Petit Prince", 
      "photo": null, 
      "age_min": 6, 
      "age_max": 10, 
      "description": "Un petit garçon...",
      "pages": [ // ✅ Zidna pages hna bach n-testiw bihom
        {"num_page": 1, "contenu": "Il était une fois...", "image": "p1.jpg", "audio": "a1.mp3"},
        {"num_page": 2, "contenu": "Le petit prince...", "image": "p2.jpg", "audio": null},
      ]
    },
    {
      "id": 2, 
      "titre": "L'Alchimiste", 
      "photo": null, 
      "age_min": 12, 
      "age_max": 18, 
      "description": "Un berger...",
      "pages": [] 
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF9FAFB),
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0.5,
        title: const Text("📚 Liste des Livres", 
          style: TextStyle(color: Color(0xFF1F2937), fontWeight: FontWeight.bold, fontSize: 18)),
        actions: [_buildAddButton(context)],
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Container(
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              border: Border.all(color: const Color(0xFFF3F4F6)),
            ),
            child: Column(
              children: [
                _buildTableHeader(),
                ListView.separated(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  itemCount: livres.length,
                  separatorBuilder: (context, index) => const Divider(height: 1),
                  itemBuilder: (context, index) => _buildLivreRow(livres[index]),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildTableHeader() {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 8),
      color: const Color(0xFFF9FAFB),
      child: const Row(
        children: [
          Expanded(flex: 1, child: _HeaderText("ID")),
          Expanded(flex: 2, child: _HeaderText("PHOTO")),
          Expanded(flex: 4, child: _HeaderText("TITRE")),
          Expanded(flex: 2, child: _HeaderText("ÂGE")),
          Expanded(flex: 3, child: _HeaderText("PAGES", color: Colors.blue)),
          Expanded(flex: 3, child: _HeaderText("ACTION")),
        ],
      ),
    );
  }

  Widget _buildLivreRow(Map<String, dynamic> livre) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 8),
      child: Row(
        children: [
          Expanded(flex: 1, child: Center(child: Text("#${livre['id']}"))),
          Expanded(flex: 2, child: _buildPhotoThumbnail(livre['photo'])),
          Expanded(flex: 4, child: Text(livre['titre'], style: const TextStyle(fontWeight: FontWeight.w600))),
          Expanded(flex: 2, child: _buildAgeBadge(livre)),

          // 📄 ACTIONS PAGES
          Expanded(
            flex: 3,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _IconButton(
                  icon: Icons.visibility_outlined,
                  color: Colors.blue,
                  onTap: () => Navigator.push(context, MaterialPageRoute(
                    builder: (context) => IndexPage(livre: livre, pages: livre['pages'] ?? []),
                  )),
                ),
                _IconButton(
                  icon: Icons.add_circle_outline,
                  color: Colors.teal,
                  onTap: () => Navigator.push(context, MaterialPageRoute(
                    builder: (context) => AddPageScreen(livre: livre),
                  )),
                ),
              ],
            ),
          ),

          // ⚙️ ACTIONS LIVRE
          Expanded(
            flex: 3,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _IconButton(
                  icon: Icons.edit_outlined,
                  color: Colors.amber[700]!,
                  onTap: () => Navigator.push(context, MaterialPageRoute(
                    builder: (context) => ModifierLivreScreen(livre: livre),
                  )),
                ),
                _IconButton(icon: Icons.delete_outline, color: Colors.redAccent, onTap: () {}),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildAddButton(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: OutlinedButton.icon(
        onPressed: () => Navigator.push(context, MaterialPageRoute(builder: (context) => const AjouterLivreScreen())),
        icon: const Icon(Icons.add, size: 16),
        label: const Text("Ajouter"),
      ),
    );
  }

  Widget _buildPhotoThumbnail(String? url) => const Center(child: Icon(Icons.book, color: Colors.grey));
  Widget _buildAgeBadge(Map livre) => Center(child: Text("${livre['age_min']}-${livre['age_max']}"));
}

class _HeaderText extends StatelessWidget {
  final String text; final Color? color;
  const _HeaderText(this.text, {this.color});
  @override
  Widget build(BuildContext context) => Center(child: Text(text, style: TextStyle(fontSize: 9, fontWeight: FontWeight.bold, color: color ?? Colors.grey)));
}

class _IconButton extends StatelessWidget {
  final IconData icon; final Color color; final VoidCallback onTap;
  const _IconButton({required this.icon, required this.color, required this.onTap});
  @override
  Widget build(BuildContext context) => IconButton(onPressed: onTap, icon: Icon(icon, size: 18, color: color));
}