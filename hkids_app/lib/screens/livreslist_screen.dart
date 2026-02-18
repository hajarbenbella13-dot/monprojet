import 'package:flutter/material.dart';

class LivresListScreen extends StatefulWidget {
  const LivresListScreen({super.key});

  @override
  State<LivresListScreen> createState() => _LivresListScreenState();
}

class _LivresListScreenState extends State<LivresListScreen> {
  // Mock data f blast l-API l-ba9i majm3nachhom
  final List<Map<String, dynamic>> livres = [
    {
      "id": 1,
      "titre": "Le Petit Prince",
      "photo": null,
      "age_min": 6,
      "age_max": 10
    },
    {
      "id": 2,
      "titre": "L'alchimiste",
      "photo": "https://via.placeholder.com/150",
      "age_min": 12,
      "age_max": 18
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF9FAFB), // gray-50
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0.5,
        title: const Text(
          "📚 Liste des Livres",
          style: TextStyle(color: Color(0xFF1F2937), fontWeight: FontWeight.bold, fontSize: 18),
        ),
        actions: [
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
            child: ElevatedButton.icon(
              onPressed: () {
                // Navigator l-page Ajouter
              },
              icon: const Icon(Icons.add, size: 18),
              label: const Text("Ajouter"),
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.white,
                foregroundColor: const Color(0xFF4B5563),
                elevation: 0,
                side: const BorderSide(color: Color(0xFFD1D5DB)),
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
              ),
            ),
          ),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Container(
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12),
            border: Border.all(color: const Color(0xFFF3F4F6)),
            boxShadow: [
              BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10, offset: const Offset(0, 4)),
            ],
          ),
          child: Column(
            children: [
              // Header dyal l-jadwal (Thead)
              Container(
                padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 8),
                decoration: const BoxDecoration(
                  color: Color(0xFFF9FAFB),
                  borderRadius: BorderRadius.only(topLeft: Radius.circular(12), topRight: Radius.circular(12)),
                  border: Border(bottom: BorderSide(color: Color(0xFFF3F4F6))),
                ),
                child: const Row(
                  children: [
                    Expanded(flex: 1, child: _HeaderText("ID")),
                    Expanded(flex: 2, child: _HeaderText("PHOTO")),
                    Expanded(flex: 4, child: _HeaderText("TITRE")),
                    Expanded(flex: 2, child: _HeaderText("ÂGE")),
                    Expanded(flex: 3, child: _HeaderText("ACTIONS")),
                  ],
                ),
              ),
              // Body dyal l-jadwal
              livres.isEmpty
                  ? const Padding(
                      padding: EdgeInsets.all(32),
                      child: Text("Aucun livre trouvé 📭", style: TextStyle(color: Colors.grey)),
                    )
                  : ListView.separated(
                      shrinkWrap: true,
                      physics: const NeverScrollableScrollPhysics(),
                      itemCount: livres.length,
                      separatorBuilder: (context, index) => const Divider(height: 1, color: Color(0xFFF3F4F6)),
                      itemBuilder: (context, index) {
                        final livre = livres[index];
                        return _buildLivreRow(livre, index);
                      },
                    ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildLivreRow(Map<String, dynamic> livre, int index) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 8),
      child: Row(
        children: [
          // ID
          Expanded(
            flex: 1,
            child: Center(
              child: Text("#${index + 1}", style: const TextStyle(color: Colors.grey, fontSize: 12, fontFamily: 'monospace')),
            ),
          ),
          // Photo
          Expanded(
            flex: 2,
            child: Center(
              child: Container(
                width: 35,
                height: 35,
                decoration: BoxDecoration(
                  color: const Color(0xFFF9FAFB),
                  borderRadius: BorderRadius.circular(4),
                  border: Border.all(color: const Color(0xFFE5E7EB)),
                ),
                child: livre['photo'] != null
                    ? ClipRRect(
                        borderRadius: BorderRadius.circular(4),
                        child: Image.network(livre['photo'], fit: BoxFit.cover),
                      )
                    : const Center(child: Text("N/A", style: TextStyle(fontSize: 8, color: Colors.grey))),
              ),
            ),
          ),
          // Titre
          Expanded(
            flex: 4,
            child: Text(
              livre['titre'],
              style: const TextStyle(fontWeight: FontWeight.w500, color: Color(0xFF374151), fontSize: 13),
              overflow: TextOverflow.ellipsis,
            ),
          ),
          // Âge
          Expanded(
            flex: 2,
            child: Center(
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                decoration: BoxDecoration(
                  color: const Color(0xFFEEF2FF),
                  borderRadius: BorderRadius.circular(4),
                  border: Border.all(color: const Color(0xFFE0E7FF)),
                ),
                child: Text(
                  "${livre['age_min']}-${livre['age_max']}",
                  style: const TextStyle(color: Color(0xFF4F46E5), fontSize: 10, fontWeight: FontWeight.bold),
                ),
              ),
            ),
          ),
          // Actions
          Expanded(
            flex: 3,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _ActionButton(icon: Icons.visibility_outlined, color: Colors.blue, onTap: () {}),
                _ActionButton(icon: Icons.edit_outlined, color: Colors.amber, onTap: () {}),
                _ActionButton(icon: Icons.delete_outline, color: Colors.redAccent, onTap: () => _confirmDelete(context)),
              ],
            ),
          ),
        ],
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

// Helper Widgets
class _HeaderText extends StatelessWidget {
  final String text;
  const _HeaderText(this.text);
  @override
  Widget build(BuildContext context) => Center(
        child: Text(text, style: const TextStyle(fontSize: 10, fontWeight: FontWeight.bold, color: Color(0xFF6B7280))),
      );
}

class _ActionButton extends StatelessWidget {
  final IconData icon;
  final Color color;
  final VoidCallback onTap;
  const _ActionButton({required this.icon, required this.color, required this.onTap});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(4),
      child: Padding(
        padding: const EdgeInsets.all(4.0),
        child: Icon(icon, size: 18, color: color),
      ),
    );
  }
}