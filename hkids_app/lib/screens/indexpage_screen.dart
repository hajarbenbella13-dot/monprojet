import 'package:flutter/material.dart';
import 'modifierpages_screen.dart'; 
// 1. Zid l-import dyal AddPageScreen hna
import 'addpages_screen.dart'; 

class IndexPage extends StatelessWidget {
  final Map livre;
  final List pages;

  const IndexPage({super.key, required this.livre, required this.pages});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF3F4F6),
      appBar: AppBar(
        elevation: 0.5,
        backgroundColor: Colors.white,
        foregroundColor: Colors.black,
        title: RichText(
          text: TextSpan(
            style: const TextStyle(color: Colors.black, fontSize: 18, fontWeight: FontWeight.w600),
            children: [
              const TextSpan(text: "Pages du Livre : "),
              TextSpan(
                text: "${livre['titre']}",
                style: const TextStyle(color: Colors.blue, fontWeight: FontWeight.bold),
              ),
            ],
          ),
        ),
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 8.0),
            child: TextButton.icon(
              onPressed: () {
                // ✅ 2. Navigation vers AddPageScreen
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => AddPageScreen(livre: livre),
                  ),
                );
              },
              icon: const Icon(Icons.add, size: 18),
              label: const Text("Ajouter"),
              style: TextButton.styleFrom(
                backgroundColor: Colors.blue,
                foregroundColor: Colors.white,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
              ),
            ),
          ),
        ],
      ),
      body: pages.isEmpty ? _buildEmptyState() : _buildGrid(context),
    );
  }

  // ... (Ba9i l-Widgets b7al _buildEmptyState o _buildGrid khellihom kif kano)
  
  Widget _buildEmptyState() {
    return const Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.library_books, size: 60, color: Colors.grey),
          SizedBox(height: 10),
          Text("Aucune page ajoutée pour ce livre.", style: TextStyle(color: Colors.grey)),
        ],
      ),
    );
  }

  Widget _buildGrid(BuildContext context) {
    return GridView.builder(
      padding: const EdgeInsets.all(16),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        childAspectRatio: 0.75,
        crossAxisSpacing: 12,
        mainAxisSpacing: 12,
      ),
      itemCount: pages.length,
      itemBuilder: (context, index) {
        final page = pages[index];
        return _buildPageCard(context, page);
      },
    );
  }

  Widget _buildPageCard(BuildContext context, Map page) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.grey.shade200),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 5)],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          InkWell(
            onTap: () {
               // Hna imken t-zid navigation l ShowPageScreen ila bghiti
               print("Voir page ${page['num_page']}");
            },
            borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
            child: Padding(
              padding: const EdgeInsets.all(12),
              child: Row(
                children: [
                  ClipRRect(
                    borderRadius: BorderRadius.circular(8),
                    child: Image.network(
                      "http://10.0.2.2:8000/storage/${page['image'] ?? ''}", // 🌐 Emulator IP
                      width: 64,
                      height: 64,
                      fit: BoxFit.cover,
                      errorBuilder: (context, error, stackTrace) =>
                          Container(width: 64, height: 64, color: Colors.grey[100], child: const Icon(Icons.image)),
                    ),
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Text(
                              "P. ${page['num_page']}",
                              style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14),
                            ),
                            if (page['audio'] != null)
                              const Icon(Icons.volume_up, size: 14, color: Colors.green),
                          ],
                        ),
                        Text(
                          page['contenu'] ?? "",
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: TextStyle(color: Colors.grey[600], fontSize: 12),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const Spacer(),
          const Divider(height: 1, thickness: 0.5),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              IconButton(
                icon: const Icon(Icons.edit_outlined, color: Colors.amber, size: 20),
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => ModifierPageScreen(page: page, livre: livre),
                    ),
                  );
                },
              ),
              IconButton(
                icon: const Icon(Icons.delete_outline, color: Colors.red, size: 20),
                onPressed: () => _showDeleteDialog(context, page['num_page']),
              ),
            ],
          ),
        ],
      ),
    );
  }

  void _showDeleteDialog(BuildContext context, dynamic pageId) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text("Supprimer ?"),
        content: const Text("Voulez-vous supprimer cette page ?"),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Non")),
          TextButton(
            onPressed: () => Navigator.pop(context), 
            child: const Text("Oui", style: TextStyle(color: Colors.red))
          ),
        ],
      ),
    );
  }
}