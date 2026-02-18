import 'package:flutter/material.dart';
import 'ajouterlivre_screen.dart';
import 'modifierlivre_screen.dart';

class LivresListScreen extends StatefulWidget {
  const LivresListScreen({super.key});

  @override
  State<LivresListScreen> createState() => _LivresListScreenState();
}

class _LivresListScreenState extends State<LivresListScreen> {
  // Mock data
  final List<Map<String, dynamic>> livres = [
    {
      "id": 1,
      "titre": "Le Petit Prince",
      "photo": null,
      "age_min": 6,
      "age_max": 10,
      "description": "Conte philosophique."
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
        actions: [
          _buildAddButton(context),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Container(
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12),
            border: Border.all(color: const Color(0xFFF3F4F6)),
            boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10)],
          ),
          child: Column(
            children: [
              _buildTableHeader(),
              livres.isEmpty
                  ? const Padding(padding: EdgeInsets.all(32), child: Text("Aucun livre trouvé 📭"))
                  : ListView.separated(
                      shrinkWrap: true,
                      physics: const NeverScrollableScrollPhysics(),
                      itemCount: livres.length,
                      separatorBuilder: (context, index) => const Divider(height: 1, color: Color(0xFFF3F4F6)),
                      itemBuilder: (context, index) => _buildLivreRow(livres[index], index),
                    ),
            ],
          ),
        ),
      ),
    );
  }

  // --- 1. Table Header (b7al Laravel dyalk) ---
  Widget _buildTableHeader() {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 8),
      decoration: const BoxDecoration(
        color: Color(0xFFF9FAFB),
        borderRadius: BorderRadius.only(topLeft: Radius.circular(12), topRight: Radius.circular(12)),
        border: Border(bottom: BorderSide(color: Color(0xFFF3F4F6))),
      ),
      child: Row(
        children: [
          const Expanded(flex: 1, child: _HeaderText("ID")),
          const Expanded(flex: 2, child: _HeaderText("PHOTO")),
          const Expanded(flex: 4, child: _HeaderText("TITRE")),
          const Expanded(flex: 2, child: _HeaderText("ÂGE")),
          // --- Action Pages Header (Blue style) ---
          Expanded(flex: 3, child: Container(
            padding: const EdgeInsets.symmetric(vertical: 4),
            decoration: BoxDecoration(color: const Color(0xFFEFF6FF), borderRadius: BorderRadius.circular(4)),
            child: const _HeaderText("ACTION PAGES", color: Colors.blue),
          )),
          const Expanded(flex: 3, child: _HeaderText("ACTION LIVRE")),
        ],
      ),
    );
  }

  // --- 2. Table Row ---
  Widget _buildLivreRow(Map<String, dynamic> livre, int index) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 8),
      child: Row(
        children: [
          Expanded(flex: 1, child: Center(child: Text("#${index + 1}", style: const TextStyle(fontSize: 11, color: Colors.grey)))),
          
          Expanded(flex: 2, child: _buildPhotoThumbnail(livre['photo'])),
          
          Expanded(flex: 4, child: Text(livre['titre'], style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 13))),

          Expanded(flex: 2, child: _buildAgeBadge(livre)),

          // --- SECTION: ACTION PAGES (Blue/Emerald) ---
          Expanded(
            flex: 3,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _IconButton(icon: Icons.visibility, color: Colors.blue, onTap: () {
                  // Route pages.index
                }),
                _IconButton(icon: Icons.add_circle, color: const Color(0xFF10B981), onTap: () {
                  // Route pages.create
                }),
              ],
            ),
          ),

          // --- SECTION: ACTION LIVRE (Amber/Red) ---
          Expanded(
            flex: 3,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _IconButton(icon: Icons.edit, color: Colors.amber[700]!, onTap: () {
                   Navigator.push(context, MaterialPageRoute(builder: (context) => ModifierLivreScreen(livre: livre)));
                }),
                _IconButton(icon: Icons.delete, color: Colors.redAccent, onTap: () => _confirmDelete(context)),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // --- UI Helpers ---
  Widget _buildAddButton(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: OutlinedButton.icon(
        onPressed: () => Navigator.push(context, MaterialPageRoute(builder: (context) => const AjouterLivreScreen())),
        icon: const Icon(Icons.add, size: 16),
        label: const Text("+ Ajouter", style: TextStyle(fontWeight: FontWeight.bold)),
        style: OutlinedButton.styleFrom(
          foregroundColor: const Color(0xFF4B5563),
          side: const BorderSide(color: Color(0xFFD1D5DB)),
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
        ),
      ),
    );
  }

  Widget _buildPhotoThumbnail(String? url) {
    return Center(
      child: Container(
        width: 32, height: 32,
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(6),
          border: Border.all(color: Colors.black12),
        ),
        child: url != null 
          ? ClipRRect(borderRadius: BorderRadius.circular(6), child: Image.network(url, fit: BoxFit.cover))
          : const Icon(Icons.image_not_supported, size: 14, color: Colors.grey),
      ),
    );
  }

  Widget _buildAgeBadge(Map livre) {
    return Center(
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
        decoration: BoxDecoration(color: const Color(0xFFEEF2FF), borderRadius: BorderRadius.circular(4), border: Border.all(color: const Color(0xFFE0E7FF))),
        child: Text("${livre['age_min']}-${livre['age_max']}", style: const TextStyle(color: Color(0xFF4F46E5), fontSize: 10, fontWeight: FontWeight.bold)),
      ),
    );
  }

  void _confirmDelete(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text("Supprimer ?"),
        content: const Text("Voulez-vous vraiment supprimer ce livre ?"),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Annuler")),
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Supprimer", style: TextStyle(color: Colors.red))),
        ],
      ),
    );
  }
}

// Custom Header Widget
class _HeaderText extends StatelessWidget {
  final String text;
  final Color color;
  const _HeaderText(this.text, {this.color = const Color(0xFF6B7280)});
  @override
  Widget build(BuildContext context) => Center(
    child: Text(text, style: TextStyle(fontSize: 9, fontWeight: FontWeight.bold, color: color)),
  );
}

// Custom Icon Button
class _IconButton extends StatelessWidget {
  final IconData icon;
  final Color color;
  final VoidCallback onTap;
  const _IconButton({required this.icon, required this.color, required this.onTap});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(4),
      child: Padding(
        padding: const EdgeInsets.all(6.0),
        child: Icon(icon, size: 18, color: color),
      ),
    );
  }
}